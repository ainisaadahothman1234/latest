<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{

    use HasFactory;
    public $timestamps = true;

    protected $guarded = [];
    
    use SoftDeletes; // Add this line
    protected $dates = ['deleted_at'];

    protected $table = 'training';

    public function applies()
    {
        return $this->hasMany(Apply::class, 'staff_id');
    }

    public static function External(){
        $External=Training::where('approve_ceo', 'Pending')
        ->where('req_id',Auth()->user()->staff_id)
        ->get();

        return $External;  
    }

    public static function getName($code)
    {
        return Training::where('code', $code)->pluck('title');
    }
}
