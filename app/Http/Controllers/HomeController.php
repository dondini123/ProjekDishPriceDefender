<?php

namespace App\Http\Controllers;

use App\Models\{Role, User, Review, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authorize;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";

        if (auth()->user()->role != 1) {
            return $this->redirectToRole(auth()->user()->role);
        }

        $product = User::where('role', 2)->get();
        return view("/home/index", compact("title" ,"product"));
    }

    public function admin(){
        $title = "Admin Home";

        if (auth()->user()->role != 3) {
          
        
            return $this->redirectToRole(auth()->user()->role);
        }

        return view("/home/admin", compact("title"));
    }

    public function vendor(){
        $title = "Vendor Home";
        $status = 1;
        if (auth()->user()->role != 2) {
           
            return $this->redirectToRole(auth()->user()->role);
        }
        $id = auth()->user()->id;
        $product_total = Product::where('user_id' , $id)->count();
        $product_ids = Product::where('user_id' , $id)->pluck('id');

        $reviews = Review::whereIn('product_id' , $product_ids)->where('approve', $status)->get(); 
       
        $product = Product::where('user_id' , $id)->get();
     


        $user = auth()->user();

        if ($reviews->count() == 0) {
            $rate = 0;
        } else {
            $rate = $reviews->sum("rating") / $reviews->count();
        }

        $starCounter = [];
        $sum = 0;
        for ($i = 1; $i <= 5; $i++) {
            $total = count(Review::where('rating' , $i )->whereIn('product_id' , $product_ids)->where('approve', $status)->get());
            array_push($starCounter,  $total);
            $sum += $total;
        }

       
        return view("/home/vendor", compact("title","rate","sum", "starCounter","reviews","product_total",'product'));
    }


   public function vendor_specific($pid){

    $title = "Vendor Home";
    $status = 1;
    
    if (auth()->user()->role != 2) {
       
        return $this->redirectToRole(auth()->user()->role);
    }
    $id = auth()->user()->id;
    $product_ids = Product::where('user_id' , $id)->pluck('id');
    $reviews = Review::whereIn('product_id' , $product_ids)->where('product_id' , $pid)->where('approve', $status)->get();
   
    $product = Product::where('user_id' , $id)->get();
    $product_total =0;
    $user = auth()->user();

    if ($reviews->count() == 0) {
        $rate = 0;
    } else {
        $rate = $reviews->sum("rating") / $reviews->count();
    }

    $starCounter = [];
    $sum = 0;
    for ($i = 1; $i <= 5; $i++) {
        $total = count(Review::where('rating' , $i )->whereIn('product_id' , $product_ids)->where('product_id' , $pid)->where('approve', $status)->get());
        array_push($starCounter,  $total);
        $sum += $total;
    }

    
    return view("/home/vendor", compact("title","rate","sum", "starCounter","reviews","product_total",'product'));

   }



    public function customers()
    {

        $title = "Customers";
        $customers = User::all();

        return view("home/customers",  compact("title", "customers"));
    }

    public function show_customer($id){
        $title = 'Show customer';

        $data = User::find($id);
       
        return view('admin/show_customer', compact("title", "data"));
    }

    public function edit_customers($id){
        $title= "edit customer";

        $data = User::find($id);

        return view('admin.edit_cusomer', compact('title', 'data'));
    }


    public function editPost(Request $request, $id){
        $title= "edit customer";
        $input = $request->all();
        $data = User::find($id);
       
       
        $data->update($input);  

        $message = "Has been updated!";

        myFlasherBuilder(message: $message, success: true);
        return redirect('/home/customers');

    }


    public function delete($id){

        User::destroy($id);
        $message = "Has been deleted!";

        myFlasherBuilder(message: $message, success: true);
        return redirect('/home/customers');
    }

    
    private function redirectToRole($role)
    {
        switch ($role) {
            case 2:
                return redirect()->route('home.vendor');
            case 3:
                return redirect()->route('home.admin');
            case 1:
                return redirect()->route('home.index');
        }
    }

}
