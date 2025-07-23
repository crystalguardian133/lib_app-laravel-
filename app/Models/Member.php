<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Specify custom table name
    protected $table = 'members';

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'age',
        'address',
        'contactnumber',
        'school',
        'memberdate',
        'member_time'
    ];

    // Automatically cast date fields (optional)
    protected $casts = [
        'memberdate' => 'date',
    ];
}

