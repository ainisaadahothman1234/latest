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
    public function index(Request $request)
    {
        return view('general.password.new');
    }

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
        
        User::where('staff_id', $attributes['staff_id'])
        ->update(['password' => bcrypt($attributes['new_password'])], ['email'=> $email]);

        session()->flash('success', 'Password updated successfully.');
        
        if (Auth()->user()->position === 'admin') {
            return back()->with('success', 'Password updated successfully.');
        }
        return redirect('/login')->with('success', 'Password updated successfully.');
    }

    public function forgot(){

        return view('general.forgot');

    }
    
}
