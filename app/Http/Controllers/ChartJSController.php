<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\User;
use App\Models\Apply;
use Illuminate\View\View;

class ChartJSController extends Controller
{
    /**
     * Display a chart using Chart.js
     *
     * @return View
     */

    //function within a controller typically handles the retrieval and display of a collection of resources.
    public function index(): View
    {
        $role = Auth()->user()->position;
        $labels = [];
        $data = [];
        $staffData = [];

        // if the position is admin, it display the monthly training hours based on the service
        if ($role === 'admin') {
            $chartData = $this->getAdminChartData();
            $labels = $chartData->keys('service');
            $data = $chartData->values('training_hours');
        }
        //if the position is hos, it display the monthly training hours based on their service 
        elseif ($role === 'hos') {
            $chartData = $this->getHosService();
            $staffData = $chartData['staffData'];
            $labels = $chartData['staffData']->pluck('name');
            $data = $chartData['staffData']->pluck('training_hours');
        } 
        //if the position is staff, it display their monthly training hours
        elseif ($role === 'staff') {
            $chartData = $this->getStaffChart();
            $staffData = $chartData['staffData'];
            $labels = $chartData['staffData']->pluck('month');
            $data = $chartData['staffData']->pluck('training_hours');
        }

        return view('chart', compact('labels', 'data', 'staffData'));
    }

    //this function to capture data from db that required to display at admin chart
    private function getAdminChartData()
    {
        // Get the current month (e.g., October)
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Customize your query for admin data here
        $chartData = Apply::select(
                'users.service', // Select the service column
                DB::raw("SUM(training_hrs) as training_hours")
            )
            ->join('users', 'users.staff_id', '=', 'staff_apply.staff_id')
            ->where('apply_status', 'Completed')
            ->whereYear('staff_apply.created_at', $currentYear)
            ->whereMonth('staff_apply.created_at', $currentMonth) // Filter by the current month
            ->groupBy('users.service')
            ->pluck('training_hours', 'users.service');

        return $chartData;
    }

    //this function to capture data from db that required to display at hos chart
    private function getHosService()
    {
         // Customize your query for hospital staff data here
         $staffData = User::select('users.service', 'users.name',DB::raw('SUM(staff_apply.training_hrs) as training_hours')) 
         ->join('staff_apply', 'users.staff_id', '=', 'staff_apply.staff_id')
         ->where('staff_apply.apply_status', 'Completed')
         ->where('users.service', Auth()->user()->service)
         ->groupBy('users.service', 'users.name')
         ->get();
     
        return compact('staffData');
    }

    //this function to capture data from db that required to display at staff chart
    private function getStaffChart()
    {
        // Get the authenticated user's staff_id and the current year
        $staffId = Auth()->user()->staff_id;
        $currentYear = date('Y');

        // Customize your query for the authenticated staff member's data, for all months in the current year
        $staffData = User::select(DB::raw('SUM(staff_apply.training_hrs) as training_hours'), DB::raw("DATE_FORMAT(staff_apply.created_at, '%M') as month"))
        ->join('staff_apply', 'users.staff_id', '=', 'staff_apply.staff_id')
        ->where('users.staff_id', $staffId) // Filter data for the authenticated user's staff_id
        ->where('staff_apply.apply_status', 'Completed')
        ->whereYear('staff_apply.created_at', $currentYear) // Filter by the current year
        ->groupBy('month') // Include 'month' in the GROUP BY clause
        ->get();
    
        return compact('staffData');
    }
}
