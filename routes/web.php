<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, HomeController, OrderController, PointController, ReviewController, ProductController, ProfileController, RajaOngkirController, TransactionController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// pre authenticate
Route::middleware(['alreadyLogin'])->group(function () {
    // landing
    Route::get('/', function () {
        return view('landing.index', [
            "title" => "Landing",
        ]);
    });

    // Login
    Route::get('/{url}', [AuthController::class, "loginGet"])->where(["url" => "auth|auth/login"])->name("auth");
    Route::post('/auth/login', [AuthController::class, "loginPost"]);
    
    // Register
    Route::get('/auth/register', [AuthController::class, "registrationGet"]);
    Route::post('/auth/register', [AuthController::class, "registrationPost"]);
    Route::get('/forget-password', [App\Http\Controllers\ForgetPasswordManager::class,"forgetPassword"])->name("forget.password");
    Route::post('/forget-password', [App\Http\Controllers\ForgetPasswordManager::class,"forgetPasswordPost"])->name("forget.password.post");
    Route::get('/reset/password/{token}', [App\Http\Controllers\ForgetPasswordManager::class,"resetPassword"])->name("reset.password");
    Route::post("/reset-password",  [App\Http\Controllers\ForgetPasswordManager::class,"resetPasswordpost"])->name("reset.password.post");
});




Route::controller(ProfileController::class)->group(function () {
    Route::get("/profile/my_profile", "myProfile");
    Route::get("/profile/edit_profile", "editProfileGet");
    Route::post("/profile/edit_profile/{user:id}", "editProfilePost");
    Route::get("/profile/change_password", "changePasswordGet");
    Route::post("/profile/change_password", "changePasswordPost");
});

// auth for dashboard
Route::get('/home/index', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('/home/admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('home.admin')->middleware('role:3');
Route::get('/home/vendor', [App\Http\Controllers\HomeController::class, 'vendor'])->name('home.vendor')->middleware('role:2');



Route::group(['middleware' => ['auth']], function() {

    Route::controller(ProductController::class)->group(function () {
        Route::get("/product", "index");
        Route::get("/product/items/{id}", "getProductData");
    });
   
    Route::get("/review/data/{id}", [App\Http\Controllers\ReviewController::class, 'getDataReview']);
    Route::get("/review/product/{product}", [App\Http\Controllers\ReviewController::class, "productReview"]);
    Route::post("/review/add_review/{product}",[App\Http\Controllers\ReviewController::class, "addReview"]);
    Route::get("/review/edit_review/{review}", [App\Http\Controllers\ReviewController::class , "editReview"]);
       
    Route::controller(ReviewController::class)->group(function () {
       Route::post("/review/delete_review/{review}", "deleteReview");
    });

});

Route::group(['middleware' => ['auth', 'role:2']], function () {

    Route::get("/rating", [App\Http\Controllers\ReviewController::class, 'getDataReview']);
    Route::get('/home/vendor/{id}' , [App\Http\Controllers\HomeController::class , 'vendor_specific'])->middleware('role:2');;

    Route::controller(ProductController::class)->group(function () {
        Route::get("/product/list", "product");
        Route::get("/product/add_product", "addProductGet");
        Route::post("/product/add_product", "addProductPost");
        Route::get("/product/edit_product/{product:id}", "editProductGet")->name('product.edit_product');
        Route::post("/product/edit_product/{product:id}", "editProductPost")->name('product.update');
        Route::get("/product/show_product/{id}", "show")->name('product.show_product');
        Route::delete("/product/delete_product/{product}", "destroy")->name('product.destroy');

    });

});



Route::group(['middleware' => ['auth', 'role:3']], function () {


    Route::get('/home/customers', [App\Http\Controllers\HomeController::class, 'customers'])->name('home.customers');
    Route::get('/customer/show/{id}', [App\Http\Controllers\HomeController::class, 'show_customer']);
    Route::get('/customers/edit/{id}', [App\Http\Controllers\HomeController::class,  'edit_customers']);  
    Route::post('/customer/post/{id}',[App\Http\Controllers\HomeController::class,  'editPost']);
    Route::delete('/customer/delete/{id}',[App\Http\Controllers\HomeController::class,  'delete']);
    
    Route::get('/admin/rating/index', [App\Http\Controllers\ReviewController::class, 'admin_index']);
    Route::get('/admin/rating/show/{id}', [App\Http\Controllers\ReviewController::class, 'admin_show']);
    Route::post('/admin/rating/update/{id}/{action}', [App\Http\Controllers\ReviewController::class, 'admin_update']);
    
    Route::get('/report', [App\Http\Controllers\AdminReport::class, 'admin_report']);
    Route::get('/check/{userId}', [App\Http\Controllers\ReportController::class, 'generate_check']);
    Route::post('/generate-report/{userId}', [App\Http\Controllers\ReportController::class, 'generate'])->name('generate_report');

    // Order
    Route::controller(OrderController::class)->group(function () {
        Route::get("/order/order_data", "orderData");
        Route::get("/order/order_history", "orderHistory");
        Route::get("/order/order_data/{status_id}", "orderDataFilter");
        Route::get("/order/data/{order}", "getOrderData")->can("my_real_order", "order");
        Route::get("/order/getProof/{order}", "getProofOrder")->can("my_real_order", "order");


        // customer only
        Route::get("/order/make_order/{product:id}", "makeOrderGet")->can("create_order", App\Models\Order::class);
        Route::post("/order/make_order/{product:id}", "makeOrderPost")->can("create_order", App\Models\Order::class);
        Route::get("/order/edit_order/{order}", "editOrderGet")->can("edit_order", "order");
        Route::post("/order/edit_order/{order}", "editOrderPost")->can("edit_order", "order");
        Route::get("/order/delete_proof/{order}", "deleteProof")->can("delete_proof", "order");
        Route::post("/order/cancel_order/{order}", "cancelOrder")->can("cancel_order", "order");
        Route::post("/order/upload_proof/{order}", "uploadProof")->can("upload_proof", "order");

        // admin only
        Route::post("/order/reject_order/{order}/{product}", "rejectOrder")->can("reject_order", App\Models\Order::class);
        Route::post("/order/end_order/{order}/{product}", "endOrder")->can("end_order", App\Models\Order::class);
        Route::post("/order/approve_order/{order}/{product}", "approveOrder")->can("approve_order", App\Models\Order::class);
    });

    // Ongkir
    Route::controller(RajaOngkirController::class)->group(function () {
        Route::get("/shipping/province", "province");
        Route::get("/shipping/city/{province_id}", "city");
        Route::get("/shipping/cost/{origin}/{destination}/{quantity}/{courier}", "cost");
    });


    // review
    Route::controller(ReviewController::class)->group(function () {
        Route::get("/review/product/{product}", "productReview");
        Route::get("/review/data/{review}", "getDataReview");
        Route::post("/review/add_review/", "addReview");
        Route::post("/review/edit_review/{review}", "editReview")->can("edit_review", "review");
        Route::post("/review/delete_review/{review}", "deleteReview")->can("delete_review", "review");
    });

    // transaction
    Route::controller(TransactionController::class)->group(function () {
        Route::get("/transaction", "index")->can("is_admin");
        Route::get("/transaction/add_outcome", "addOutcomeGet")->can("is_admin");
        Route::post("/transaction/add_outcome", "addOutcomePost")->can("is_admin");
        Route::get("/transaction/edit_outcome/{transaction}", "editOutcomeGet")->can("is_admin");
        Route::post("/transaction/edit_outcome/{transaction}", "editOutcomePost")->can("is_admin");
    });

    // point
    Route::controller(PointController::class)->group(function () {
        Route::get("/point/user_point", "user_point")->can("user_point", App\Models\User::class);
        Route::post("/point/convert_point", "convert_point")->can("convert_point", App\Models\User::class);
    });


    // chart
    Route::middleware(['can:is_admin'])->group(function () {
        // sales chart
        Route::get("/chart/sales_chart", function () {
            $oneWeekAgo = DB::select(DB::raw('SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 6 DAY), "%Y-%m-%d") AS date'))[0]->date;

            $now = date('Y-m-d', time());

            $array_result = [
                "one_week_ago" => $oneWeekAgo,
                "now" => $now,
            ];

            //disable ONLY_FULL_GROUP_BY
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $array_result["data"] = DB::table("orders")
                ->selectSub("count(*)", "sales_total")
                ->selectSub("DATE_FORMAT(orders.updated_at, '%d')", "day")
                ->selectSub("DATE_FORMAT(orders.updated_at, '%Y-%m-%d')", "date")
                ->where("is_done", 1)
                ->whereBetween(DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d')"), ["$oneWeekAgo", $now])
                ->groupByRaw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d')")
                ->get();
            //re-enable ONLY_FULL_GROUP_BY
            DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

            echo json_encode($array_result);
        });
        // profits chart
        Route::get("/chart/profits_chart", function () {
            $six_month_ago = DB::select(DB::raw('SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), "%Y-%m") AS month'))[0]->month;
            $now = date('Y-m', time());
            $array_result = [
                "six_month_ago" => $six_month_ago,
                "now" => $now,
            ];

            //disable ONLY_FULL_GROUP_BY
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $array_result["data"] = DB::table("transactions")
                ->selectSub("SUM(income) - SUM(outcome)", "profits")
                ->selectSub("DATE_FORMAT(transactions.created_at, '%Y-%m')", "date")
                ->whereBetween(DB::raw("DATE_FORMAT(transactions.created_at, '%Y-%m')"), ["$six_month_ago", $now])
                ->groupByRaw("DATE_FORMAT(transactions.created_at, '%Y-%m')")
                ->get();
            //re-enable ONLY_FULL_GROUP_BY
            DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

            echo json_encode($array_result);
        });
    });

 
});
   // Logout
   Route::post('/auth/logout', [AuthController::class, "logoutPost"]);
