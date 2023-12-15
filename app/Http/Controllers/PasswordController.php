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
        // Get the current authenticated user
    $user = auth()->user();
    
    // Check if the current password matches 'password'
    if(Hash::check('password', $user->password)){
        // If it matches, allow capturing email
        $attributes = $request->validate([
            'email' => 'required|email',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
            'staff_id' => 'required'
        ]);
        // Assign the captured email
            $email = $attributes['email'];
            } else {
                // If the password doesn't match 'password', proceed without capturing email
                $attributes = $request->validate([
                    'new_password' => 'required',
                    'confirm_password' => 'required|same:new_password',
                    'staff_id' => 'required'
                ]);
                // Use the user's existing email
                $email = $user->email;
            }
            
            // Updates the password in the database based on the provided 'staff_id'
            User::where('staff_id', $attributes['staff_id'])
                ->update(['password' => bcrypt($attributes['new_password']), 'email' => $email]);

            session()->flash('success', 'Password updated successfully.');

            if ($user->position === 'admin') {
                return back()->with('success', 'Password updated successfully.');
            }
            return redirect('/login')->with('success', 'Password updated successfully.');

    }

}
