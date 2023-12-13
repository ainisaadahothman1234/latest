<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Apply;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseApprovalNotification;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\AdminTrainingRequest;

class AdminController extends Controller
{
    //index function -  the retrieval and display of a collection of resources.
    public function index(Request $request)
    {
        $chart=0;

        if ($request->has('reset_filter')) {
            // Set filter values to their defaults (e.g., current month and year)
            $filterMonth = date('m');
            $filterYear = date('Y');

            $userCount = $this->userCount();
            $countTraining = $this->countTraining();
            $reqTraining = $this->reqTraining();
            $percentage = $this->percentage();

        } else {
            // Use the selected filter values (month and year)
            $filterMonth = $request->input('filter_month', date('m'));
            $filterYear = $request->input('filter_year', date('Y'));

            $userCount = $this->getUserCount($request->input('filter_month', date('m')), $request->input('filter_year', date('Y')));
            $countTraining = $this->getCountTraining($request->input('filter_month', date('m')), $request->input('filter_year', date('Y')));
            $reqTraining = $this->getReqTraining($request->input('filter_month', date('m')), $request->input('filter_year', date('Y')));
            $percentage = $this->getPercentage($request->input('filter_month', date('m')), $request->input('filter_year', date('Y')));
            $chart = $this->getChartData($request);

        }

        return view('admin.home', [
            'userCount' => $userCount,
            'countTraining' => $countTraining,
            'reqTraining' => $reqTraining,
            'percentage' => $percentage,
            'chart' => $chart,
            'filterMonth' => $filterMonth, // Pass the selected month
            'filterYear' => $filterYear, // Pass the selected year
        ])->with('success', 'Welcome!');
        
    }

    //display add training form
    public function viewForm()
    {
        return view('admin.form');
    }

    //display training form - this use where admin want to edit the training in the form.
    public function showForm(Request $request)
    {
        $training = Training::where('code', $request->code)->first();
        return view('admin.edit', ['training' => $training]);
    }

    //to show / display the list of training
    public function show()
    {
        return view('admin.list', ['Tadd' => Training::all()]);
    }

    //count total number of user/staff. this display at the homepage
    public function userCount()
    {
        $userCount = User::whereNotIn('position', ['admin', 'itadmin'])->count();
        return $userCount;
    }

    //count total number of training exists. this display at the homepage.
    public function countTraining()
    {
        $countTraining = Training::count();
        return $countTraining;
    }

    //count total number of training exists. this display at the homepage.
    public function reqTraining()
    {
        $reqTraining = Training::where('category', '=', 'External')->count();
        return $reqTraining;
    }

    //calculate the percentage of staff completed 30 hours training
    public function percentage()
    {
        $staffWith30HoursOrMore = Apply::where('apply_status', 'Completed')
            ->select('staff_id')
            ->groupBy('staff_id')
            ->havingRaw('SUM(training_hrs) >= 30')
            ->get();
        
        $totalStaff = User::whereIn('staff_id', $staffWith30HoursOrMore->pluck('staff_id')->toArray())
            ->whereNotIn('position', ['admin', 'itadmin'])
            ->count();
        
            if ($totalStaff > 0) {
                $percentage = ($totalStaff / User::whereNotIn('position', ['admin', 'itadmin'])->count()) * 100;
                // Format the percentage to two decimal places
                $percentage = number_format($percentage, 2);
        } else {
            $percentage = 0; // handle the case where there are no staff members with 30 or more hours
        }
        
        // Append '%' symbol to the percentage
        $percentage = $percentage . '%';
        
        return $percentage;
    }

    //to store training (for new training)
    public function store(AdminTrainingRequest $request)
    {
        $attributes = $request->validated();

        // Generate the 'code' based on the full category name and the latest code in the database
        /*$latestCode = Training::where('category', $attributes['category'])
            ->orderBy('id', 'desc')
            ->first();

        $categoryName = $attributes['category'];

        if (!$latestCode) {
            $nextNumber = '001';
        } else {
            $lastCode = substr($latestCode->code, -3);
            $nextNumber = str_pad((int) $lastCode + 1, 3, '0', STR_PAD_LEFT);
        }

        $attributes['code'] = $categoryName . '-' . $nextNumber;*/

        $attributes['status'] = 'Upcoming';
        // Create a new training record with the generated 'code'
        Training::create($attributes);

        session()->flash('success', 'New training add successfully');
        // Redirect to the list view with the updated list of trainings
        return view('admin.list', ['Tadd' => Training::all()]);
    }

    //for admin to update the training that already posted
    public function update(AdminUpdateRequest $request)
    {

        $attributes = $request->validated();
        Training::where('code', $request->code)->update($attributes);
        session()->flash('success', 'New training add successfully');
        return redirect("/training/lists");
    }

    //for admin to delete the training
    public function delete(AdminUpdateRequest $request)
    {

        Training::where('code', $request->code)->delete();

        session()->flash('success', 'Delete successfully');
        return redirect("/training/lists");
    }

    //for admin to approve the requested training (training that request by HOS)
    public function approve(AdminUpdateRequest $request)
    {

        $attributes = $request->validated();
        Training::where('code', $request->code)->update($attributes);

        return redirect("/training/req")->with('add success', 'New training being approved!');
    }

    //for admin to reject the requested training (training that request by HOS)
    public function reject(AdminUpdateRequest $request)
    {

        Training::where('code', $request->code)->reject();

        session()->flash('success', 'Delete successfully');
        return redirect("/training/lists");
    }

    //display the list of staff 
    public function listStaff()
    {
        $staffList = User::whereNotIn('position', ['admin', 'ITadmin'])
        ->orderBy('staff_id', 'asc')
        ->get();
        return view('admin.staff_list', compact('staffList'));
    }

    //function for admin to mark the attendance
    public function attendanceStaff($Tcode)
    {
        $attendanceList = User::whereIn('staff_id', function ($query) use ($Tcode) {
            $query->select('staff_id')
                ->from('staff_apply')
                ->where('training_code', $Tcode)
                ->where('apply_status', 'Approved');
        })->get();

        $attendStaff = User::join('staff_apply', 'users.staff_id', '=', 'staff_apply.staff_id')
            ->whereIn('users.staff_id', function ($query) use ($Tcode) {
                $query->select('staff_id')
                    ->from('staff_apply')
                    ->where('training_code', $Tcode)
                    ->whereIn('apply_status', ['Completed', 'Incompleted']);
            })
            ->where('training_code', $Tcode)
            ->whereIn('apply_status', ['Completed', 'Incompleted'])
            ->orderBy('staff_apply.apply_status', 'asc') // Order by 'apply_status' column in ascending order
            ->get(['users.*', 'staff_apply.*']);


        return view('admin.attendance', [
            'attendanceList' => $attendanceList,
            'attendStaff' => $attendStaff,
            'Tcode' => $Tcode,
        ]);
    }

    //function to mark as completed in db when admin mark the attendance as completed
    public function updateAttend(Request $request, $Tcode)
    {
        foreach ($request->selectedStaff as $staff) {
            Apply::where('training_code', $Tcode)
                ->where('staff_id', $staff)
                ->update(['apply_status' => 'Completed']);
        }
        return redirect("/attendance/$Tcode");
    }

    //function to mark as completed in db when admin mark the attendance as completed
    public function training()
    {
        $training = Training::where('type', 'external')->where('status', 'Pending')->get();
        return view('admin.training', compact('training'));
    }

    //function to print the requested training
    public function print($code)
    {
        $training = Training::where('code', $code)->first();
        return view('admin.print', compact('training'));
    }

    //when staff training is approved by HOS. Admin receive the notification. 
    public function trainingApprove($Tcode)
    {
        $training = Training::where('code', $Tcode)->first();
        Training::where('code', $Tcode)->update(['status' => 'Approved']);

        $detail = <<<HTML
    <ul>
        <li>Training: $training->title</li>
        <li>User: $training->req_id</li>
    </ul>
    HTML;
        HistoryController::store('External Training applies', 'Approved', $detail);
        HistoryController::store('External Training applies', 'Approved', $detail, $training->req_id);
        session()->flash('success', 'Successfully Approved the training');
        return redirect('/training/req');
    }

    //this function when the requested training rejected. The details will appear in log activity/history page
    public function trainingReject($Tcode)
    {

        $training = Training::where('code', $Tcode)->first();

        Training::where('code', $Tcode)->delete();
        $detail = <<<HTML
    <ul>
        <li>Training: $training->title</li>
        <li>User: $training->req_id</li>
    </ul>
    HTML;
        HistoryController::store('External Training applies', 'Rejected', $detail);
        HistoryController::store('External Training applies', 'Rejected', $detail, $training->req_id);
        session()->flash('success', 'Successfully Rejected the training');
        return redirect('/training/req');
    }

    //store attended staff. it display in log activity/history page
    public function attend($staff_id, Request $request)
    {
        $training_hrs = $request['training_hrs_' . $staff_id];
        $training_code = $request['training_code_' . $staff_id];
        $attend_type = $request['attend_type_' . $staff_id];

        if (!is_numeric($training_hrs) or $attend_type === 'null') {
            return back()->with('error', 'Check your data input');
        }

        $detail = <<<HTML
        <ul>
            <li>Training: $training_code</li>
            <li>User: $staff_id</li>
        </ul>
        HTML;

        if ($request->action == 'attend') {


            // Update the 'apply_status' and 'training_hrs' fields
            Apply::where('training_code', $training_code)
                ->where('staff_id', $request->staff_id)
                ->update([
                    'apply_status' => 'Completed',
                    'training_hrs' => $training_hrs,
                    'attend_type' => $attend_type
                ]);

            HistoryController::store('Training Attendence', 'Attend', $detail);
            HistoryController::store('Training Attendence', 'Attend', $detail, $staff_id);
        } else {
            Apply::where('training_code', $training_code)
                ->where('staff_id', $request->staff_id)
                ->update([
                    'apply_status' => 'Incompleted',
                    'training_hrs' => $training_hrs,
                ]);
            HistoryController::store('Training Attendence', 'Incomplete', $detail);
            HistoryController::store('Training Attendence', 'Incomplete', $detail, $staff_id);
        }

        session()->flash('success', 'Attendance recorded successfully.');
        return redirect()->back();
    }

    public function absent(Request $request)
    {
    }
    
    //This function use to update the status training in db. when it already exceed the date end, the training status updated to Completed.
    public static function updateTrainingStatus()
    {
        // Get all the trainings that have exceeded the end date and have a status of 'Pending'.
        $expiredTrainings = Training::where('date_end', '<', now())
            ->where('status', 'Upcoming')
            ->update(['status' => 'Completed']);
            
            session()->flash('success', 'Attendance recorded successfully.');
            return back();
    }

    //This function use to count number of user. This function create to enable it to display the data based on the filtered data
    private function getUserCount($filterMonth, $filterYear)
    {
        // Modify your query to filter user count based on $filterMonth and $filterYear.
        $userCount = User::whereNotIn('position', ['admin', 'itadmin'])
            ->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->count();

        return $userCount;
    }

   //This function use to count number of training. This function create to enable it to display the data based on the filtered data 
    private function getCountTraining($filterMonth, $filterYear)
    {
        // Modify your query to filter training count based on $filterMonth and $filterYear.
        $countTraining = Training::whereMonth('date_start', $filterMonth)
            ->whereYear('date_start', $filterYear)
            ->count();

        return $countTraining;
    }

    //This function use to count number of requested training. This function create to enable it to display the data based on the filtered data
    private function getReqTraining($filterMonth, $filterYear)
    {
        // Modify your query to filter requested training count based on $filterMonth and $filterYear.
        $reqTraining = Training::where('category', 'External')
            ->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->count();

        return $reqTraining;
    }

    //This function use to calculate the percentage of the user completed 30 hours training. This function create to enable it to display the data based on the filtered data
    public function getPercentage($filterMonth, $filterYear) {
        $staffWith30HoursOrMore = Apply::where('apply_status', 'Completed')
            ->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->select('staff_id')
            ->groupBy('staff_id')
            ->havingRaw('SUM(training_hrs) >= 30')
            ->get();

        $totalStaff = User::whereIn('staff_id', $staffWith30HoursOrMore->pluck('staff_id')->toArray())
            ->whereNotIn('position', ['admin', 'itadmin'])
            ->count();

        if ($totalStaff > 0) {
            $percentage = ($totalStaff / User::whereNotIn('position', ['admin', 'itadmin'])->count()) * 100;
            // Format the percentage to two decimal places
            $percentage = number_format($percentage, 2);
        } else {
            $percentage = 0; // handle the case where there are no staff members with 30 or more hours
        }

        // Append '%' symbol to the percentage
        $percentage = $percentage . '%';

        return $percentage;
    }

    //to get all the carddata which is getUserCount, getCountTraining, getReqTraining, getPercentage
    public function getCardData(Request $request)
    {
        // Retrieve the selected month and year from the query parameters.
        $filterMonth = $request->input('filter_month');
        $filterYear = $request->input('filter_year');

        // Retrieve user count based on the selected filter
        $userCount = $this->getUserCount($filterMonth, $filterYear);

        // Retrieve training count based on the selected filter
        $countTraining = $this->getCountTraining($filterMonth, $filterYear);

        // Retrieve requested training count based on the selected filter
        $reqTraining = $this->getReqTraining($filterMonth, $filterYear);

        // Retrieve percentage based on the selected filter
        $percentage = $this->getPercentage($filterMonth, $filterYear);

        // Add your logic to fetch other card data as needed and replace these values.

        // Return the card data as JSON
        return response()->json([
            'totalStaff' => $userCount,
            'totalTraining' => $countTraining,
            'reqTraining' => $reqTraining,
            'percentage' => $percentage,
        ]);
    }

    //to get all the chartdata
    public function getChartData(Request $request) {

        // Retrieve the selected month and year from the query parameters.
        $filterMonth = $request->input('filter_month');
        $filterYear = $request->input('filter_year');

        // Define empty arrays for labels and data.
        $labels = [];
        $data = [];
        
        // Add your logic here to retrieve chart data based on $filterMonth and $filterYear.
        // You can reuse the logic from your existing 'index' method but with the filters applied.
        
        // Customize your query for admin data here
        // Get the current month (e.g., October)
        $currentMonth = date('Y-m');
        
        $chartData = Apply::select(
            'users.service', // Select the service column
            DB::raw("SUM(training_hrs) as training_hours")
        )
            ->join('users', 'users.staff_id', '=', 'staff_apply.staff_id')
            ->where('apply_status', 'Completed')
            ->whereYear('staff_apply.created_at', $filterYear)
            ->whereMonth('staff_apply.created_at', $filterMonth)
            ->groupBy('users.service')
            ->get(); // Use get() to retrieve data instead of pluck()
    
        // Populate $labels and $data arrays based on $chartData
        foreach ($chartData as $item) {
            $labels[] = $item->service; // Populate labels with service names
            $data[] = $item->training_hours; // Populate data with training hours
        }
        
        // Return the chart data as JSON
        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }  

    //to get all the displayTbaleChart
    public function displayTableChart($currentMonth,$currentYear)
    {
        $filterMonth= $currentMonth;
        $filterYear=$currentYear;

        //$filterMonth = $request->input('filter_month', date('m'));
        //$filterYear = $request->input('filter_year', date('Y'));
        $serviceData = [];

        $services = DB::table('users')->distinct()->pluck('service');
        foreach ($services as $service) {
            $Users = DB::table('users')->where('service', $service)->pluck('staff_id');
            $serviceData[$service]['total_hrs'] = 0; // Initialize the total hours count for each service
            $serviceData[$service]['total_staff'] = 0; // Initialize the total hours count for each service

            foreach ($Users as $User) {
                $TrainingHours = StaffController::getHour($User);
                $serviceData[$service]['total_staff'] += 1;
                if ($TrainingHours >= 30) {
                    $serviceData[$service]['total_hrs'] += 1; // Increment the total hours count for this service
                }
            }

            // Calculate the percentage for each service
            if ($serviceData[$service]['total_staff'] > 0) {
                $percentage = ($serviceData[$service]['total_hrs'] / $serviceData[$service]['total_staff']) * 100;
                $serviceData[$service]['percentage_completed'] = number_format($percentage, 2) . '%';
            } else {
                $serviceData[$service]['percentage_completed'] = '0%';
            }
        }

        // Returning the fetched data as a JSON response
        return view('tableChart',[
            'serviceData' => $serviceData,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear,
        ]);
    }
 
}