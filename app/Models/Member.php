<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    // Specify custom table name
    protected $table = 'members';

    // Allow mass assignment for these fields
    protected $fillable = [
        'uuid',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'house_number',
        'street',
        'barangay',
        'municipality',
        'province',
        'contactnumber',
        'email',
        'email_verified',
        'school',
        'memberdate',
        'member_time',
        'photo',
        'phone_verified'
    ];

    // Automatically cast date fields (optional)
    protected $casts = [
        'memberdate' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Member $member) {
            if (empty($member->uuid)) {
                $member->uuid = (string) Str::uuid();
            }
        });
    }

    public function getNameAttribute()
{
    $parts = [
        $this->first_name,
        $this->middle_name !== 'null' ? $this->middle_name : null,
        $this->last_name
    ];

    return implode(' ', array_filter($parts));
}
}

