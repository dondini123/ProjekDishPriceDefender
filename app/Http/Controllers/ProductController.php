<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Product";
        $product = User::where('role', 2)->get();

        return view('/product/index', compact("title", "product"));
    }


    public function getProductData($id)
    {
        $title = "Product";
        $product = Product::where('user_id', $id)->get();
        return view('/product/product', compact("title", "product"));
    }


    public function addProductGet()
    {
        $title = "Add Product";

        return view('/product/add_product', compact("title"));
    }


    public function addProductPost(Request $request)
    {
        $validatedData = $request->validate([
            "product_name" => "required|max:25",
            "stock" => "required|numeric|gt:0",
            "price" => "required|numeric|gt:0",
            "discount" => "required|numeric|gt:0|lt:100",
            "orientation" => "required",
            "description" => "required",
            "image" => "image|max:2048"
        ]);
        if ($request->hasFile('image')) {
        
              $imagePath = public_path('product_images/' . $request->file('image')->getClientOriginalName());
        
              // Store the uploaded file directly in the 'public/product_images' directory
              $request->file('image')->move('product_images', $request->file('image')->getClientOriginalName());
      
              // Add the image path to the validated data
              $validatedData['image'] = 'product_images/' . $request->file('image')->getClientOriginalName();
        }

        try {
            $validatedData['user_id'] = Auth::id();
           
            
            Product::create($validatedData);
            $message = "Product has been added!";
         
            myFlasherBuilder(message: $message, success: true);

            return redirect('/product');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }

    
    public function product()
    {

        $title = "Vendor";
        $userProducts = Product::where('user_id', Auth::id())->get();

        return view("product/product_list", compact("title", "userProducts"));
    }

    

    public function editProductGet(Product $product)
    {
        $data["title"] = "Edit Product";
        $data["product"] = $product;

        return view("/product/edit_product", $data);
    }


    public function editProductPost(Request $request, Product $product)
    {
        $rules = [
            'product_name' => 'required',
            'orientation' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gt:0',
            'discount' => 'required|numeric|gt:0|lt:100',
            'image' => 'image|file|max:2048'
        ];

        $validatedData = $request->validate($rules);

        try {
            if ($request->file("image")) {
                if ($request->oldImage != env("IMAGE_PRODUCT")) {
                    // Delete the old image from the 'public/product_images' directory
                    $oldImagePath = public_path($request->oldImage);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
    
                // Use public_path to specify the full path in the public directory
                $newImagePath = public_path('product_images/' . $request->file('image')->getClientOriginalName());
                
                // Store the new image directly in the 'public/product_images' directory
                $request->file("image")->move('product_images', $request->file('image')->getClientOriginalName());
                $validatedData["image"] = 'product_images/' . $request->file('image')->getClientOriginalName();
            }
    
            $product->fill($validatedData);


            if ($product->isDirty()) {
                $product->save();

                $message = "Product has been updated!";

                myFlasherBuilder(message: $message, success: true);
                return redirect("/product");
            } else {
                $message = "Action <strong>failed</strong>, no changes detected!";

                myFlasherBuilder(message: $message, failed: true);
                return back();
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }
    

public function destroy(Product $product)
{
    $product->delete();
    
    return redirect('/product/list')->with('success', 'Product deleted successfully');

}

public function show($id){
    $title = 'Show Product';
    $data = Product::find($id);
    return view('product.show_product', compact('data' ,'title'));
   
}
}
