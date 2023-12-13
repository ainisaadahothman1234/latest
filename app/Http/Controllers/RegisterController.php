<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //Display add staff page when admin want to add new staff into the system
    public function create()
    {
        return view('admin.register');
    }

    //attributes required to fill up by admin
    public function store()
    {
        $attribute = request()->validate([
            'name' => 'required|unique:users,name|max:255|min:5',
            'staff_id' => 'required|unique:users,staff_id|max:255|min:5',
            'category' => 'required|string',
            'service' => 'required|string',
            'position' => 'required|string',
            'no' => 'required|max:255',
            'password' => 'required',
        ]);

        $attribute['password'] = $attribute['staff_id'];

        User::create($attribute);

        session()->flash('success', 'Your account has been created.');
        return redirect('/register');
    }
}
