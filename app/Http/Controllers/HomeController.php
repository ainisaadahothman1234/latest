<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //This function likely serves as the landing page or main page of your application.
    public function index()
    {
        //session()->flash('success','Successfully Log');
        return view('home')->with('success','Successfully Log');
    }
}
