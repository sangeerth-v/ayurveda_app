<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'booking_date',
        'booking_time',
        'status',
        'consultation_type',
        'google_meet_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
