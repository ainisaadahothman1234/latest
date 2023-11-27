<?php

namespace App\Models;

use App\Models\Training;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apply extends Model
{
    use HasFactory;
    protected $table = 'staff_apply';
    public $timestamps = true;

    // Define the relationship with the Training model
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_code', 'code');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
