<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\MonthlyReportExport;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyReportController extends Controller
{
    //display report view
    public function index()
    {
        return view('/reports');
    }

    //Function in generating a report
    public function generateReport(Request $request)
    {
        //month and year filteration
        $startMonth = $request->input('start_month');
        $endMonth = $request->input('end_month');
        $year = $request->input('year');

        //data needed in report when the position is admin
        if (Auth()->user()->position === 'admin') {
            $reportData = DB::table('staff_apply')
                ->join('users', 'users.staff_id', '=', 'staff_apply.staff_id')
                ->join('training', 'training.code', '=', 'staff_apply.training_code')
                ->where('staff_apply.apply_status', 'Completed')
                ->whereYear('staff_apply.created_at', $year)
                ->whereBetween(DB::raw('MONTH(staff_apply.created_at)'), [$startMonth, $endMonth])
                ->select(
                    'training.code',
                    'users.staff_id',
                    'users.category AS user_category',
                    'users.service',
                    'users.division',
                    'users.name AS user_name', // Include 'name' in the select statement
                    'training.title',
                    'training.date_start',
                    'training.date_end',
                    'training.duration',
                    'training.location',
                    'training.organizer',
                    'training.category',
                    'training.price',
                    'staff_apply.training_hrs',
                    DB::raw('COUNT(*) as total_participants'),
                    DB::raw('SUM(staff_apply.training_hrs) as total_training_hrs')
                )
                ->groupBy('training.code', 'users.staff_id', 'users.category', 'users.service', 'users.division', 'users.name', 'training.title', 'training.category', 'training.price', 'staff_apply.training_hrs')
                ->orderBy('training.date_start', 'asc')
                ->get();
        } 
        //data needed in report when the position is staff/hos
        else {
            $reportData = DB::table('staff_apply')
                ->join('users', 'users.staff_id', '=', 'staff_apply.staff_id')
                ->join('training', 'training.code', '=', 'staff_apply.training_code')
                ->where('staff_apply.apply_status', 'Completed')
                ->where('users.staff_id', Auth()->user()->staff_id)
                ->whereYear('staff_apply.created_at', $year)
                ->where(function ($query) use ($startMonth, $endMonth, $year) {
                    $query->whereBetween(DB::raw('MONTH(staff_apply.created_at)'), [$startMonth, $endMonth])
                        ->whereYear('staff_apply.created_at', $year);
                })
                ->select(
                    'training.code',
                    'users.staff_id',
                    'users.position',
                    'users.name AS user_name', // Include 'name' in the select statement
                    'training.title',
                    'training.date_start',
                    'training.date_end',
                    'training.duration',
                    'training.location',
                    'training.organizer',
                    'training.category',
                    'training.price',
                    'staff_apply.training_hrs',
                    DB::raw('COUNT(*) as total_participants'),
                    DB::raw('SUM(staff_apply.training_hrs) as total_training_hrs')
                )
                ->groupBy('training.code', 'users.staff_id', 'users.position', 'users.service', 'training.title', 'training.price', 'staff_apply.training_hrs')
                ->orderBy('training.date_start', 'asc')
                ->get();
        }

        //when download, it give report in excel format
        return Excel::download(new MonthlyReportExport($reportData), 'monthly_report.xlsx');
    }
}

