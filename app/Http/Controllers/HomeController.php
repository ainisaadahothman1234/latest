<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        //session()->flash('success','Successfully Log');
        return view('home')->with('success','Successfully Log');
    }
}
