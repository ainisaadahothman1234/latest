<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index()
    {

        $staffUpdate = User::where('staff_id', Auth()->user()->staff_id)->first();

        return view('/general/profile', [
            'staffUpdate' => $staffUpdate,
        ]);
    }

    public function update(Request $request)
    {

        $user = Auth()->user();
        
        if ($request->option == 'update') {
            $attributes = request()->validate([
                'staff_id' => 'required',
                'name' => 'required',
                'service' => 'required',
                'category' => 'required',
                'email' => 'required|email',
                'no' => 'required',
            ]);

            // Update the staff record
            User::where('staff_id', Auth()->user()->staff_id)->update($attributes);
        }

        session()->flash('success', 'Profile update success');
        return redirect('/'.$user->position.'/home');
    }
}
