<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RemoveController extends Controller
{
    public function users()
    {
        return view('admin.deleteUser');
    }

    public function deactivate(Request $request)
    {
        $attributes = $request->validate([
            'staff_id' => 'required|exists:users,staff_id'
        ]);
    
        $user = User::withTrashed()->where('staff_id', $attributes['staff_id'])->first();
    
        if ($user && $user->trashed()) {
            // User has already been soft deleted
            session()->flash('error', 'User ' . $request->staff_id . ' has already been deleted.');
        } else {
            // Soft delete the user
            User::where('staff_id', $attributes['staff_id'])->delete();
    
            $text = 'Delete Account: ' . $request->staff_id;
            HistoryController::store('Deactivate staff', 'Deactivate', $text);
    
            session()->flash('success', 'Successfully Delete ' . $request->staff_id);
        }
    
        if (auth()->user()->position === 'admin') {
            return redirect('/staff/lists');
        }
    
        return redirect('/ITadmin/home');
    }
    

    public function activate(Request $request)
    {
        $attributes = $request->validate([
            'staff_id' => 'required|exists:users,staff_id'
        ]);

        $user = User::where('staff_id', $attributes['staff_id']);
        $user->restore();

        $text = 'Activate Account: ' . $request->staff_id;
        HistoryController::store('Activate staff', 'Activate', $text);

        session()->flash('success', 'Successfully Activate ' . $request->staff_id . ' account');
        if(Auth()->user()->position === 'admin'){
            
            return redirect('/staff/lists');
        }
        return redirect('/ITadmin/home');
    }
}
