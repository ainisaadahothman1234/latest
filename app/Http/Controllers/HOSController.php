<?php

// app/Http/Controllers/HOSController.php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Apply;
use App\Models\History;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\NoApplicationConflicts;
use App\Http\Requests\externalRequest;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\HistoryController;

class HOSController extends Controller
{
    public function index()
    {
        $request = Request::capture();
        return (new FilterController)->sideFilter($request);
    }

    public function showForm()
{
    $services = [
        Auth()->user()->service,
        Auth()->user()->service2,
    ];

    // Retrieve staff members who belong to either service or service2
    $staff = User::where(function ($query) use ($services) {
                    $query->whereIn('service', $services)
                          ->orWhereIn('service2', $services);
                })
                ->get();

    return view('hos/form', ['staffMembers' => $staff]);
}


    public function store(ExternalRequest $request)
    {
        
        $randomString = Str::random(5);
        $attributes = $request->validated();
        $attributes['created_at'] = now()->toDateTimeString();

        $test = new NoApplicationConflicts();
        $test = $test->passes('no conflict', $attributes);
        if ($test === true) {
            return back()->with('duplicate', 'You have submitted this training');
        }

        $attributes['code'] = substr($attributes['category'], 0, 3) . $randomString;


        return redirect('/external/form')->with(['ETraining' => $attributes]);
    }

    public function sideFilter(Request $request)
    {
        $query = DB::table('training');

        // Apply type filter if provided
        if ($request->filled('filterType')) {
            $query->whereIn('type', $request->input('filterType'));
        }

        // Apply category filter if provided
        if ($request->filled('filterCategory')) {
            $query->whereIn('category', $request->input('filterCategory'));
        }

        $trainingList = $query->get();

        return view('hos.home', compact('trainingList'));
    }

    public function assignStaff(Request $request)
    {
        session(['selectedStaff' => $request->selectedStaff]);

        // Return the filtered view or redirect as needed
        return (new FilterController)->sideFilter($request);
    }

    public function external(request $request)
    {
        $selectedStaff = $request->selectedStaff;
        $training = $Etraining = json_decode($request->input('Etraining'), true);


        Training::insert($training);

        foreach ($selectedStaff as $staffid) {
            Apply::insert(
                [
                    'training_code' => $training['code'],
                    'staff_id' => $staffid,
                    'training_hrs' => $training['duration'],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'apply_status'=>'approved',
                ]
            );

            $text = <<<HTML
                <p>You have request for external training:<h5>{$training['title']}</h5></p>
                
            HTML;

            HistoryController::store('Create External Training', 'External', $text);

            session()->flash('success', 'Successfully, assign External training');
            return redirect('/'.Auth()->user()->position.'/home');
        }
    }

    public function notification(Request $request)
    {
        // Get staff information: staff-id and name
        $user = User::where('staff_id', session('staffID'))->first();

        // Retrieve the training title using the relationship
        $apply = Apply::where('staff_id', session('staffID'))->first();
    }
}
