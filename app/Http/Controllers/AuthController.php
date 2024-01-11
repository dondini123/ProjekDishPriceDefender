<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;


class AuthController extends Controller
{
    public function loginGet()
    {
        $title = "Login";

        if (auth()->check()) {
            
            $user = auth()->user();
    
            switch ($user->role) {
                case 3:
                    return redirect()->route('home.admin');
                case 2:
                    return redirect()->route('home.vendor');
                case 1:
                    return redirect()->route('home.index');
            }
        }

        return view('/auth/login', compact("title"));
    }

    public function loginPost(Request $request)
    {

        $input = $request->all();
        $this->validate($request,[
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if(auth()-> attempt(array('email'=>$input['email'], 'password'=> $input['password']))){

            $request->session()->regenerate();
            $message = "Login success";

            myFlasherBuilder(message: $message, success: true);

            if(auth()-> user()->role==3){
                return redirect()->route('home.admin');
            }else if(auth()-> user()->role==2){
                return redirect()->route('home.vendor');
            }else{
                return redirect()->route('home.index');
            }
        }else{
            $message = "Wrong credential";
            myFlasherBuilder(message: $message, failed: true);
            return back();
        }
    }



    public function registrationGet()
    {
        $title = "Registration";

        return view('/auth/register', compact("title"));
    }

    public function registrationPost(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:15',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'role' => 'required|numeric',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        if ($request->hasFile('image')) {

            $imagePath = public_path('profile_images/' . $request->file('image')->getClientOriginalName());
        
            // Store the uploaded file directly in the 'public/product_images' directory
            $request->file('image')->move('profile_images', $request->file('image')->getClientOriginalName());
    
            // Add the image path to the validated data
            $validatedData['image'] = 'profile_images/' . $request->file('image')->getClientOriginalName();
        }


        $validatedData = array_merge($validatedData, [
            "coupon" => 0,
            "point" => 0,
            'remember_token' => Str::random(30),
        ]);
        
        try {
            User::create($validatedData);
            $message = "Congratulations, your account has been created!";

            myFlasherBuilder(message: $message, success: true);

            return redirect('/auth/login');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }


    public function logoutPost()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $message = "Session ended, you logout <strong>successfully</strong>";

            myFlasherBuilder(message: $message, success: true);

            return redirect('/auth');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }
  
}
