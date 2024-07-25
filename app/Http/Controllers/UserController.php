<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register form
    public function create(){
        return view('users.register');
    }

    public function store(Request $request){

        //dd($request);
        $formFields = $request->validate([
            'name' => ['required', 'min:6'],
            'email' => ['required','email', Rule::unique('users','email')],
            'password' => 'required|confirmed|min:6'

        ]);

        //Hashed the password
        $formFields['password'] = bcrypt($formFields['password']);

        $user= User::create($formFields);
        //Authenticate the logged
        auth()->login($user);

        return redirect('/')->with('message', 'User created successfully and logged in');
    }

    public function logout(Request $request){
        
        auth()->logout();
        // Invalidate session and regenerate another token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','User Logout');
    }

    public function login(){
        return view('users.login');
    }

    public function authenticate(Request $request){
        $formfields = $request->validate([
            'email' => ['required','email'],
            'password' => 'required'
        ]);
         //attempt login
         if(auth()->attempt($formfields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in');

         }
        //auth::authenticate($formfields);
        //once attempt to logged in is wrong
        return back()->withErrors(['email'=>'Invalid Credentails'])->withInput(['email']);

       
    }

}
