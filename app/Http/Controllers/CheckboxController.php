<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckboxController extends Controller
{
    //

    public function index()
    {
        $staffInService = DB::table('users')->get();
        return view('hos.assign_staff', compact('staffInService'));
    }
}
