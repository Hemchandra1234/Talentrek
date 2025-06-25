<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseekers extends Model
{
    use HasFactory;

    protected $table = 'jobseekers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone_code',
        'phone_number',
        'date_of_birth',
        'city',
        'address',
        'password',
        'pass',
        'role',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     */
    protected $hidden = [
        'password',
        'pass',
    ];
}
