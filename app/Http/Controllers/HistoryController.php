<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHistoryRequest;
use App\Http\Requests\UpdateHistoryRequest;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store($title, $action, $detail, $staffID = null)
    {
        $user = Auth()->user();

        if ($staffID === null) {
            $staffID = $user->staff_id;
        }

        History::insert([
            'staff_id' => $staffID,
            'position' => $user->position,
            'title' => $title,
            'action' => $action,
            'date' => date('Y-m-d H:i:s'), // Convert timestamp to MySQL date format
            'details' => $detail,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = Auth()->user();
        $staffID = $user->staff_id;
        $selectedYear = $request->input('year', date('Y'));

        $history = History::where('staff_id', $staffID)
            ->whereYear('date', $selectedYear)
            ->orderBy('date', 'desc')
            ->get();

        return view('general.history', ['history' => $history, 'selectedYear' => $selectedYear]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHistoryRequest $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }
}
