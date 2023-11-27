<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    use SoftDeletes; // Add this line
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function hasRole($role)
    {
        return Auth()->user()->position  === $role;
    }

    public function applies()
    {
        return $this->hasMany(Apply::class, 'staff_id');
    }

    /**
     * Accessor to calculate the training hours.
     *
     * @return float
     */
    public function getTrainingHrsAttribute()
    {
        // Calculate training hours based on completed applies
        return $this->applies()
            ->where('apply_status', 'Completed')
            ->sum('training_hrs');
    }

    public static function getName($staff_id)
    {
        return User::where('staff_id', $staff_id)->pluck('name');
    }
}
