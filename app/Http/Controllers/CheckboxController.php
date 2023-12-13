<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckboxController extends Controller
{
    //this function to enable checkbox to work
    public function index()
    {
        $staffInService = DB::table('users')->get();
        return view('hos.assign_staff', compact('staffInService'));
    }
}
