<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //when admin want to register or add a new staff. This function will display the register view
    public function viewRegister()
    {
        return view('admin.register');
    }
    
    //this function display the login page when user want to login
    public function login()
    {
        return view('general.index');
    }

    //
    public function registerPost(RegistrationRequest $request)
    {
        $attributes = $request->validated();

        $attributes['staff_id'];
        
        User::create($attributes);

        session()->flash('success', 'Register successfully');
        return back();
    }

    //this function use to capture the staff id and password when user login
    public function loginPost(Request $request)
    {
        $attributes = request()->validate([
            'staff_id' => 'required',
            'password' => 'required'
        ]);

        //if success, this will display a successful message
            if (Auth::attempt($attributes, true)) {

                if (Hash::check('password', auth()->user()->password)) {
                    return redirect('/password/new');
                    exit();
                }
                $user = Auth()->user();
                
                session()->flash('success', 'Welcome!');
                return redirect('/'.$user->position.'/home');
            }

            //if invalid staff or forgot password. This will display the error message
            throw ValidationException::withMessages([
                'staff_id' => 'Cannot verify your Staff ID'
            ]);
    }
    
    //this is logout function
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
