<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    //Display the staff under the HOS services
    public function getStaff(){
        return $this->hasMany(User::class, 'staff_id');
    }
}
