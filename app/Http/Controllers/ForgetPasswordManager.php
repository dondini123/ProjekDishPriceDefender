<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ForgetPasswordManager extends Controller
{
    function forgetPassword(){
        $title = "Forget Password";
        return view("auth/forget-password", compact("title"));
    }

   function forgetPasswordPost(Request $request){
     $request->validate([
        'email' => "required|email|exists:users",
     ]);
     $token = Str::random(64);

     DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now()
     ]);

     Mail::send("auth.email.forget-password", ["token" => $token], function($message) use ($request){
        $message->to($request->email);
        $message->subject("Reset password");

     });
     return redirect()->to(route("forget.password"))->with("success", "We send the reset password email.");
   }

   function resetPassword($token){
      $title = "Change Password";
      return view("auth/new-password", compact("token", "title"));
   }

   function resetPasswordpost(Request $request){
      $request->validate([
         "email" => "required|exists:users,email",
         "password" => "required|string|min:8|confirmed",
         "password_confirmation" => "required",
      ]);

      $updatePassword = DB::table('password_resets')->where([
         "email" => $request->email,
         "token" => $request->token
      ])->first();

      if(!$updatePassword){
         return redirect()->to(route("reset.password"))->with("error" , "Invalid");

      }
      User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

      DB::table("password_resets")->where(["email" => $request->email])-> delete();

      return redirect()->to(route("auth", ['url' => 'auth/login']))->with("success", "password reset success");

   }
}
