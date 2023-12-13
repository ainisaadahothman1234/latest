<?php

namespace App\Models;

use App\Models\Training;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apply extends Model
{
    use HasFactory;

    //the data capture into staff_apply database
    protected $table = 'staff_apply';

    //$timestamps used to capture the date when the data being stored in the database.
    //When $timestamps is set to true, it enables the automatic management of two specific timestamp fields: created_at and updated_at.
    public $timestamps = true;

    // Define the relationship with the Training model
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_code', 'code');
    }

    //get the staff details
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
