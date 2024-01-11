<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\{Role, User, Review, Product};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    

public function generate($id)
{

    $title = "Vendor Home";
    $status = 1;

  
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

   

    $pdf = PDF::loadView('admin.report', compact("title","rate","sum", "starCounter","reviews","product_total",'product'));

    // Return the PDF for download or display
    return $pdf->download('report.pdf');

}


public function generate_check($id){
    $title = "Vendor Home";
    $status = 1;

  
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
    return view("/admin/report", compact("title","rate","sum", "starCounter","reviews","product_total",'product'));
   
}



}
