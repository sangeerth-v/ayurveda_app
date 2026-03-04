<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorUnavailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'unavailable_date',
    ];
}
