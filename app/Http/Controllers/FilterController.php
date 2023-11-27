<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apply;
use App\Models\Training;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function sideFilter(Request $request)
    {
        $user = Auth()->user();
        $page = Request::create(url()->current())->path();

        $query = $this->buildBaseQuery($user->position, $page, $user->staff_id);

        if ($request->filled('filterType')) {
            $filterType = $request->input('filterType'); // Update this line
            $query->whereIn('type', $filterType);
        }

        if ($request->filled('filterCategory')) {
            $filterCategory = $request->input('filterCategory'); // Update this line
            $query->whereIn('category', $filterCategory);
        }

        $trainingList = $query->get();

        return $this->createView($user->position, $page, $trainingList);
    }

    private function buildBaseQuery($position, $page, $currentUserID)
    {
        if ($page === 'assign') {
            return Training::where('type', '!=', 'External');
        }
        if ($page === Auth()->user()->position.'/training/list') {
            return Training::leftJoin('staff_apply as S', function ($join) use ($currentUserID) {
                $join->on('S.training_code', '=', 'training.code')
                    ->where('S.staff_id', '=', $currentUserID);
            })->whereNull('S.staff_id');
        } else {
            return Training::join('staff_apply as sa', 'sa.training_code', '=', 'training.code')
                ->select('training.*', 'sa.*') // Replace with actual column names
                ->where('sa.staff_id', '=', $currentUserID);
        }
    }

    private function createView($position, $page, $trainingList)
    {
        if ($position === 'hos' || $position === 'admin') {
            if ($page === 'assign' || $page === Auth()->user()->position.'/training/list') {
                return view('staff.courses', ['Tlist' => $trainingList, 'previousPage' => $page]);
            } else {
                return view('hos.home', ['Tlist' => $trainingList,]);
            }
        } elseif ($position === 'staff') {
            if ($page === Auth()->user()->position.'/training/list') {
                return view('staff.courses', ['Tlist' => $trainingList, 'previousPage' => $page]);
            } else {
                return view('staff.home', ['Tlist' => $trainingList]);
            }
        }
    }

    public function listByService()
    {
        $user = Auth()->user();

        $services = [
            $user->service,
            $user->service2,
        ];

        $staffMembers = User::where(function ($query) use ($services) {
                $query->whereIn('service', $services);
            })
            ->where('position', 'staff')
            ->get();

        return view('hos.staff_list', ['staffMembers' => $staffMembers]);
    }

    public static function fetch($Etraining = null)
    {
        $user = auth()->user();
        if (request()->is('external/form')) {
            $Etraining = session('ETraining');
            $service = User::where('staff_id', $user->staff_id)->pluck('service');
            $staff = User::where('service', Auth()->user()->service)->get();
        } else {
            $staff = Apply::where('training_code', $Etraining)->pluck('staff_id')->toArray();
            $staff = User::whereNotIn('staff_id', $staff)->where('service',$user->service)->get();
        }

        
        // Use the $ETraining parameter, not $request->ETraining
        return view('hos.assign_staff', ['staffInService' => $staff, 'ETraining' => $Etraining]);
    }
}