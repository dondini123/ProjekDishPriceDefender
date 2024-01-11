<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReport extends Controller
{
    public function admin_report(){
        $title = "Report Generate";
        $status = 1;

        if (auth()->user()->role != 3) {
           
            return $this->redirectToRole(auth()->user()->role);
        }
        $user_dtl = User::where('role', 2)->pluck('username','id')->toArray();

        $product_dtl = [];

        foreach ($user_dtl as $userId => $username) {
            $products = Product::where('user_id', $userId)->pluck('product_name')->count();
        
            $rating_dtl = Review::where('user_id', $userId)->where('approve', $status)->pluck('rating');
            $sum_of_ratings = $rating_dtl->sum();
            $average_rating = ($rating_dtl->count() > 0) ? $sum_of_ratings / $rating_dtl->count() : 0;
            $phone = User::where('id', $userId)->value('phone');

            if ($phone === null) {
               $phone = 'Not Available';
            } 

            $starCounter = [];
            for ($i = 1; $i <= 5; $i++) {
                $result = Review::where('rating', $i)->where('user_id', $userId)->where('approve', $status)->get();

                // Check if $result is not null and is countable
                if (!is_null($result) && is_countable($result) && count($result) > 0) {
                    $total = count($result);
                } else {
                    $total = 0; // Handle the case where $result is null or not countable
                }
                array_push($starCounter,  $total);  
            }

         $data  =  [
                'id' => $userId,
                'username' => $username,
                'product_count' => $products,
                'average_rating' => $average_rating,
                'starCounter' => $starCounter,
                'phone' => $phone,
            ];

           
            $product_dtl[] = $data;
    }

        return view("admin/report_index")->with(['title' => $title, 'data' => $product_dtl]);
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
