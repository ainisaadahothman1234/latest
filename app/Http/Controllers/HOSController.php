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
    //Captures the current request and delegates the filtering of training data to the FilterController's sideFilter method.
    public function index()
    {
        $request = Request::capture();
        return (new FilterController)->sideFilter($request);
    }

    //Retrieves staff members belonging to specific services and renders a form view for external training requests (hos/form view)
    public function showForm()
    {
        //This use to separate the services when 1 hos handle 2 services. for example cath lab and spd
        //this yet to develop, just some try and error
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

    //Handles the submission of external training requests.
    public function store(ExternalRequest $request)
    {
        
        $randomString = Str::random(5);
        $attributes = $request->validated();
        $attributes['created_at'] = now()->toDateTimeString();

        /**Checks for conflicts using the NoApplicationConflicts rule.
        Redirects back with a message if there's a duplicate submission or redirects to the external form page with the submitted training data.
        */
        $test = new NoApplicationConflicts();
        $test = $test->passes('no conflict', $attributes);
        if ($test === true) {
            return back()->with('duplicate', 'You have submitted this training');
        }

        $attributes['code'] = substr($attributes['category'], 0, 3) . $randomString;


        return redirect('/external/form')->with(['ETraining' => $attributes]);
    }

    //Filters training data based on type and category parameters provided in the request.
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

    //Stores selected staff in the session
    public function assignStaff(Request $request)
    {
        session(['selectedStaff' => $request->selectedStaff]);

        // Return the filtered view or redirect as needed
        return (new FilterController)->sideFilter($request);
    }

    //Handles the submission of external training requests and staff assignment.
    public function external(request $request)
    {
        $selectedStaff = $request->selectedStaff;
        $training = $Etraining = json_decode($request->input('Etraining'), true);


        //Inserts training data into the database.
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

            //Inserts staff training application data into the database and generates a notification.
            $text = <<<HTML
                <p>You have request for external training:<h5>{$training['title']}</h5></p>
                
            HTML;

            HistoryController::store('Create External Training', 'External', $text);

            //Flashes a success message and redirects to the HOS home page.
            session()->flash('success', 'Successfully, assign External training');
            return redirect('/'.Auth()->user()->position.'/home');
        }
    }

    //Retrieves staff information and training title for notifications based on session information.
    public function notification(Request $request)
    {
        // Get staff information: staff-id and name
        $user = User::where('staff_id', session('staffID'))->first();

        // Retrieve the training title using the relationship
        $apply = Apply::where('staff_id', session('staffID'))->first();
    }
}
