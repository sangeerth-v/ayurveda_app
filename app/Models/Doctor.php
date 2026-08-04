<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_plain',
        'phone',
        'medical_registration_no',
        'specialization_category',
        'specialization_subcategory',
        'district_id',
        'current_location',
        'address',
        'qualification',
        'experience',
        'consultation_fee',
        'available_time',
        'consultation_type',
        'online_available_time',
        'google_meet_link',
        'photo',
        'registration_certificate',
        'council_certificate',
        'hospital_id',
        'is_active',
    ];

    protected $casts = [
        'consultation_fee' => 'integer',
        'experience' => 'integer',
        'is_active' => 'boolean',
    ];


    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function appointments()
    {
        return $this->hasMany(DoctorToken::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
