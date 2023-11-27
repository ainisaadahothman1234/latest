<?php

namespace App\Rules;

use App\Models\Training;
use App\Models\TrainingApplication;
use Illuminate\Contracts\Validation\Rule;

class NoApplicationConflicts implements Rule
{
    public function passes($attribute, $value)
    {
        $input = request()->all();

        return Training::where('location', $input['location'])
            ->whereDate('date_start', $input['date_start'])
            ->whereDate('date_end', $input['date_end'])
            ->whereTime('time_start', $input['time_start'])
            ->whereTime('time_end', $input['time_end'])
            ->exists();
    }

    public function message()
    {
        return 'Application conflicts with an existing training application.';
    }
}
