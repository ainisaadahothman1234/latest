<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //display reset / create new password page
    public function index(Request $request)
    {
        return view('general.password.new');
    }

    //Checks if the user's current password matches the entered password. If the current password matches 'password', it accepts an email input.
    public function changePassword(Request $request)
    {
        $email = Auth()->user()->email;
        if(Hash::check('password', auth()->user()->password)){
            $attributes = $request->validate([
                'email'=>'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
                'staff_id' => 'required'
            ]);
            $email = $attributes['email'];
            
        }else{
            $attributes = $request->validate([
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
                'staff_id' => 'required'
            ]);
        }
        
        //Updates the password in the database using bcrypt() for encryption based on the provided 'staff_id'.
        User::where('staff_id', $attributes['staff_id'])
        ->update(['password' => bcrypt($attributes['new_password'])], ['email'=> $email]);

        session()->flash('success', 'Password updated successfully.');
        
        if (Auth()->user()->position === 'admin') {
            return back()->with('success', 'Password updated successfully.');
        }
        return redirect('/login')->with('success', 'Password updated successfully.');
    }

}
