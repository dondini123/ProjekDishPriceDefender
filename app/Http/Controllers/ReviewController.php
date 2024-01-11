<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\{User, Product, Review};

class ReviewController extends Controller
{
    public function productReview(User $user, Product $product)
    {
        $title = "Product Review";
        $reviews = Review::where('product_id', $id)->get();
        $user = auth()->user();

        if (count($reviews) == 0) {
            $rate = 0;
        } else {
            $rate = $reviews->sum("rating") / count($reviews);
        }

        $isPurchased = $this->isPurchased($user, $product);
        $isReviewed = $this->isReviewed($user, $product);

        $starCounter = [];
        $sum = 0;
        for ($i = 1; $i <= 5; $i++) {
            $total = count(Review::where(["rating" => $i, "product_id" => $product->id])->get());
            array_push($starCounter,  $total);
            $sum += $total;
        }

        return view("/review/product_review", compact("title", "reviews", "product", "rate", "isPurchased", "isReviewed", "starCounter", "sum"));
    }


    public function addReview(Request $request,$id)
    {
        $validatedData = $request->validate([
            "rating" => "required",
            "review" => "required"
        ]);

        $validatedData["user_id"] = auth()->user()->id;
        $validatedData["product_id"] = $id;

        Review::create($validatedData);

        $message = "Your review has been created!";

        myFlasherBuilder(message: $message, success: true);
        return back();
    }


    public function getDataReview($id)
    {
        $title = "Vendor";
        $status = 1;
        $product  = Product::where('id', $id)->first();

        
        $reviews = Review::where('product_id', $id)->where('approve', $status)->get();
        $user = auth()->user();

        if (count($reviews) == 0) {
            $rate = 0;
        } else {
            $rate = $reviews->sum("rating") / count($reviews);
        }

        $starCounter = [];
        $sum = 0;
        for ($i = 1; $i <= 5; $i++) {
            $total = count(Review::where(["rating" => $i, "product_id" => $id])->where('approve', $status)->get());
            array_push($starCounter,  $total);
            $sum += $total;
        }


        return view("/review/add_review", compact("title","product","rate","sum", "starCounter","reviews"));
    }


    public function editReview($id)
    {
        $review = Review::find($id);

        $review->fill([
            'rating' => $review->rating,
            'review' => $review->review,
        ]);

        if ($review->isDirty()) {
            $review->save();

            $message = "Your review has been updated!";

            myFlasherBuilder(message: $message, success: true);
            return back();
        } else {
            $message = "Action failed, no changes detected!";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        }
    }


    public function deleteReview(Review $review)
    {
        $review->delete();

        $message = "Your review has been deleted!";

        myFlasherBuilder(message: $message, success: true);
        return back();
    }

    private function isPurchased($user, $product)
    {
        $orders = Order::where(["user_id" => $user->id, "product_id" => $product->id, "is_done" => 1])->get();

        if (count($orders) > 0) {
            return 1;
        }

        return 0;
    }


    private function isReviewed($user, $product)
    {
        $review = Review::where(["user_id" => $user->id, "product_id" => $product->id])->get();

        if (count($review) > 0) {
            return 1;
        }

        return 0;
    }


    public function admin_index(){
        $title = "Rating Approval";

        $data= Review::with(['user', 'product'])->get();
      
        return view('/admin/index_rating', compact("title", "data"));
    }

    
    public function admin_show($id){
        $title = "Rating Approval";
        $data = Review::with(['user', 'product'])->find($id);
        
        return view('/admin/detail_rating', compact("title", "data"));
    }


    public function admin_update(Request $request, $id, $action){
        $title = "Rating Approval";
         
        $data = Review::find($id);

        if($action == 1){
            $data->update(['approve' => 1]); 

        }else if($action == 2){
            $data->update(['approve' => 2]); 
        }else{
            $message = "error code!";
            myFlasherBuilder(message: $message, false: true);
            return redirect('/admin/rating/index');
        }
       
        $message = "Status has been updated!";
    
        myFlasherBuilder(message: $message, success: true);

        return redirect('/admin/rating/index');
    }



}
