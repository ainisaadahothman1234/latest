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
    public function viewRegister()
    {
        return view('admin.register');
    }
    
    public function login()
    {
        return view('general.index');
    }

    public function registerPost(RegistrationRequest $request)
    {
        $attributes = $request->validated();

        $attributes['staff_id'];
        
        User::create($attributes);

        session()->flash('success', 'Register successfully');
        return back();
    }

    public function loginPost(Request $request)
    {
        $attributes = request()->validate([
            'staff_id' => 'required',
            'password' => 'required'
        ]);

            if (Auth::attempt($attributes, true)) {

                if (Hash::check('password', auth()->user()->password)) {
                    return redirect('/password/new');
                    exit();
                }
                $user = Auth()->user();
                
                session()->flash('success', 'Welcome!');
                return redirect('/'.$user->position.'/home');
            }

            throw ValidationException::withMessages([
                'staff_id' => 'Cannot verify your Staff ID'
            ]);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
