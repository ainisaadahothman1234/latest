<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apply;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\CourseEnrollment;
use App\Mail\CourseApprovalNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //

    public function sendNotification()
    {
        // Define the email address as a notifiable route.
        $emailAddress = Auth()->user()->email;
    
        // Define your enrollment data.
        $enrollmentData = [
            'body' => 'You received a new message',
            'enrollment' => 'Please read',
            'url' => url('/notification/application'), // You should specify the URL you want to link to.
            'thankyou' => 'Thank you!',
        ];
    
        // Check if the user is authenticated, and if not, redirect them to the login page.
        if (!Auth::check()) {
            return redirect()->intended('/notification/application');
        }
    
        Notification::route('mail', $emailAddress)->notify(new CourseEnrollment($enrollmentData));
    }
    

    public function applications()
    {
        $user = Auth()->user();
        $StaffInService = [];
        $hosID = User::where('service', $user->service)->where('position', 'hos')->pluck('staff_id');
        $notification = Apply::where('apply_status', 'Pending')
            ->where('staff_id', '!=', $user->staff_id)
            ->select('staff_id')
            ->distinct() 
            ->pluck('staff_id');
    
        foreach ($notification as $staff) {
            $service = User::where('staff_id', $staff)->pluck('service');
            if ($service->first() === $user->service) {
                $StaffInService[] = $staff;
            }
        }
    
        $staff = Apply::whereIn('staff_apply.staff_id', $StaffInService)
                        ->join('users', 'users.staff_id', '=', 'staff_apply.staff_id')
                        ->get();

        return view('hos.application', ['staff' => $staff]);
    }

    public static function showTitle($code){
        $title = Training::where('code', $code)->pluck('title');
        return $title;
    }

    public function approveApplication(Request $request)
    {
        $staffId = $request->input('staff_id');
        $code = $request->input('training_code');
        
        // Find and update the specific training application
        Apply::where('staff_id', $staffId)
            ->where('training_code', $code)
            ->update(['apply_status' => 'Approved']);
        
        // Notify the staff member who requested the course
        $staff = User::where('staff_id', $staffId)->first();
    
        if ($staff) {
            $staff->notify(new CourseEnrollment([
                'body' => 'Your course application has been approved.',
                'enrollment' => 'Congratulations!',
                'url' => url('/notification/application'),
                'thankyou' => 'Thank you!',
            ]));
        }
      
        // Notify the admin via email
        $adminEmail = User::where('service', 'admin')->pluck('email');
    
        $staffApplications = Apply::where('staff_id', $staffId)->where('training_code', $request->input('training_code'))->get();
        
        $TrainingName = Training::getName($code);
        $staffName = User::getName($staffId);
    
        $detail = <<<HTML
    <ul>
        <li>Training: $TrainingName</li>
        <li>User: $staffName</li>
    </ul>
    HTML;
    
        HistoryController::store('Staff Training applies', 'Approved', $detail);
        HistoryController::store('Staff Training applies', 'Approved', $detail, $staffId);
        Mail::to($adminEmail)->send(new CourseApprovalNotification($staffApplications));
    
        session()->flash('success', 'Application approved successfully.');
        return redirect()->back();
    }
    

    public function deleteApplication(Request $request)
    {
        $staffId = $request->input('staff_id');
        $code = $request->input('training_code');
        
        Apply::where('staff_id', $staffId)
            ->where('training_code', $code)
            ->update(['apply_status' => 'Rejected']);
        
        // Notify the staff member who requested the course
        $staff = User::where('staff_id', $staffId)->first();
        if ($staff) {
            $staff->notify(new CourseEnrollment([
                'body' => 'Your course application has been rejected.',
                'enrollment' => 'Sorry',
                'url' => url('/notification/application'),
                'thankyou' => 'Thank you!',
            ]));
        }
        $TrainingName = Training::getName($code);
        $staffName = User::getName($staffId);

        $detail = <<<HTML
        <p>Training:<h5>{$TrainingName}</h5></p>
        <p>User:<h5>{$staffName}</h5></p>
        
        HTML;
    
    
        $adminEmail = User::where('service', 'admin')
            ->pluck('email');
    
        $staffApplications = Apply::where('staff_id', $staffId)
            ->where('training_code', $request->input('training_code'))
            ->get();
    
        HistoryController::store('Staff Training applies', 'Disapproved', $detail);
        HistoryController::store('Staff Training applies', 'Disapproved', $detail, $staffId);
        Mail::to($adminEmail)->send(new CourseApprovalNotification($staffApplications));
    
        session()->flash('success', 'Application has been deleted.');
        return redirect()->back();
    }
    
    
}