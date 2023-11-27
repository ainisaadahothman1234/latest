<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apply;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CourseEnrollment;
use Illuminate\Support\Facades\Notification;

class StaffController extends Controller
{
    public function index(){
        return redirect('home');
    }
    
    public function CourseDetail($page, $trainingID)
    {
        return view('staff.' . $page, [
            'trainingID' => $trainingID
        ]);
    }
    
    public function apply(Request $request, $trainingCode)
    {
        $previous = $request->create(url()->previous())->path();
        $user = Auth::user();
        $training = Training::where('code', $trainingCode)->first();
        $approval = 'Pending';

        $staffID = [];

        if ($user->position == 'hos' || $user->position == 'admin') {

            // Fetch both services of the user if they are an HOS
            $services = [
                $user->service,
                $user->service2,
            ];

            if ($previous == Auth()->user()->position.'/training/list') {

                $staffID[0] = $user->staff_id;
                $noti = 'Successfully, apply training';
                $approvel = 'Approved';
            } else {
                $staffID = $request->selectedStaff;

                $listItems = '';
                foreach ($staffID as $staff) {
                    $listItems .= "<li>$staff</li>";
                }


                $text = <<<HTML
                <ul>
                    $listItems
                </ul>
                HTML;
                HistoryController::store('Assign Staff', 'Assign', $text);

                $noti = 'Successfully, assign training to your staff';
            }
        } else {
            $staffID[0] = $user->staff_id;
            $noti = 'Successfully, apply training';
        }

            // Filter for training clashes
            foreach ($staffID as $id) {
                $haveAnotherApply = Apply::where('staff_id', $id)->first();
                if ($haveAnotherApply) {
                    $check1 = Training::where('code', $haveAnotherApply->training_code)->first();
                    $check2 = ($check1->time_start <= $training->time_end &&
                        $check1->time_end >= $training->time_start &&
                        $check1->date_start <= $training->date_end &&
                        $check1->date_end >= $training->date_start
                    );
    
                    if ($check2) {
                        $user = User::where('staff_id', $id)->first();
                        $errorMessage = $user->name . ' has already booked another training during that time.';
    
                        // Remove HTML tags from the error message
                        $errorText = strip_tags("<p>$errorMessage</p>");
    
                        return back()->with('error', $errorText);
                    }
                }
            }

        $trainingHrs = Training::where('code', $trainingCode)->value('duration');
        foreach ($staffID as $staffid) {
            Apply::insert(
                [
                    'training_code' => $trainingCode,
                    'staff_id' => $staffid,
                    'training_hrs' => $trainingHrs,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'apply_status'=>$approval,
                ]
            );
        }

        $this->sendEmailToHOS( $trainingCode);

        session()->forget(['selectedStaff', 'page', 'selectAll']);
        session()->flash('success', $noti);
        return redirect('/'.$user->position.'/home');
    }

    public static function getHour($staffID)
    {
        return $trainingHoursTotal = Apply::where('staff_id', $staffID)
            ->where('apply_status', 'Completed')
            ->sum('training_hrs');
    }
  
    public function sendEmailToHOS( $code)
    {
        $staffUser = Auth()->user();
        // Check if the staff user has a manager with the 'hos' role.
        if ($staffUser->position === 'staff' || $staffUser->position === 'hos') {
            // Get the manager's email address.
            $managerEmail = User::where('service', $staffUser->service)->where('position','hos')->pluck('email');
            
            // Define your enrollment data.
            $enrollmentData = [
                'body' => 'You received a new training application: ',
                'enrollment' => 'Please review and approve.',
                'url' => url('/notification/application'), // You should specify the URL you want to link to.
                'thankyou' => 'Thank you!',
            ];
            
            // Send the notification to the manager (HOS).
            Notification::route('mail', $managerEmail)->notify(new CourseEnrollment($enrollmentData));
            
            // Optionally, you can send a confirmation email to the staff member.
            $staffEmail = $staffUser->email;

            $enrollmentData = [
                'body' => 'Your application has been sent.',
                'enrollment' => 'Please wait for approval.',
                'url' => url('/home'), // You should specify the URL you want to link to.
                'thankyou' => 'Thank you!',
            ];
            
            Notification::route('mail', $staffEmail)->notify(new CourseEnrollment($enrollmentData));
        }
        
        return back();
        
    }
    
    public static function getEnrolled($trainingCode)
    {
        $count = Apply::where('training_code', $trainingCode)
            ->where('apply_status', 'Approved')
            ->count();
    
        // Update the 'enrolled' column in the 'training' table
        Training::where('code', $trainingCode)
            ->update(['enrolled' => $count]);
    
        return $count;
    }
    
    public static function getStaff($service)
    {
        return $totalStaff = User::where('service', Auth()->user()->service)
            ->where('position', 'staff')
            ->count();
    }

    public static function getPercentage()
    {
        $user = Auth::user();

        if (!$user) {
            return 'User not found'; // Handle the case where the user is not found
        }

        if ($user->position === 'admin' || $user->position === 'itadmin') {
            return 'Not applicable'; // Handle the case where the user is an admin or IT admin
        }

        $totalTrainingHours = Apply::where('apply_status', 'Completed')
            ->where('staff_id', $user->staff_id)
            ->sum('training_hrs');

        if ($totalTrainingHours >= 30) {
            $percentage = 100.00;
        } else {
            $percentage = ($totalTrainingHours / 30) * 100;
        }

        // Format the percentage to two decimal places
        $percentage = number_format($percentage, 2) . '%';

        return $percentage;
    }

    public function showCompletedTraining($staff_id) {
        // Fetch completed training details for a specific staff member
        $completedTrainings = User::select('users.staff_id', 'users.name as staff_name', 'training.code as training_code', 'training.title as training_name', 'training.date_start as date_start', 'training.date_end as date_end', 'staff_apply.training_hrs as training_hour')
            ->join('staff_apply', 'users.staff_id','=','staff_apply.staff_id')
            ->where('staff_apply.apply_status', 'Completed')
            ->join('training', 'staff_apply.training_code','=','training.code')
            ->where('users.staff_id', $staff_id)
            ->get();
    
        return view('hos.staff_training', ['completedTrainings' => $completedTrainings]);
    }
    
}     