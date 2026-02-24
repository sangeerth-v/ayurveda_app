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
        'specialization_category',
        'specialization_subcategory',
        'district_id',
        'qualification',
        'experience',
        'consultation_fee',
        'available_time',
        'photo',
    ];

    public function specialization_category()
    {
        // Since we are now using string columns, we don't need a relationship here 
        // unless the user later wants to link to a Specialty table.
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function appointments()
    {
        return $this->hasMany(DoctorToken::class);
    }
}
