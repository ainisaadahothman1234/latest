<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{

    use HasFactory;

    //$timestamps used to capture the date when the data being stored in the database.
    //When $timestamps is set to true, it enables the automatic management of two specific timestamp fields: created_at and updated_at.
    public $timestamps = true;

    //$guarded is a way to protect against mass-assignment vulnerabilities. 
    //Mass assignment involves passing an array of data to a model's create() or update() methods, allowing multiple attributes to be set at once.
    //When $guarded is set to an empty array [], it indicates that no attributes are restricted from mass-assignment. 
    protected $guarded = [];
    
    use SoftDeletes; // Add this line for a way to mark records as deleted without physically removing them from the database.
    protected $dates = ['deleted_at'];

    //all data goes to training table in database.
    protected $table = 'training';

    //when staff enrolled the training (when the application is approved by HOS)
    public function applies()
    {
        return $this->hasMany(Apply::class, 'staff_id');
    }

    //when HOS apply for requested training, after submission, the status automatically be 'Pending'
    public static function External(){
        $External=Training::where('approve_ceo', 'Pending')
        ->where('req_id',Auth()->user()->staff_id)
        ->get();

        return $External;  
    }

    //get the training title
    public static function getName($code)
    {
        return Training::where('code', $code)->pluck('title');
    }
}
