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


    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function appointments()
    {
        return $this->hasMany(DoctorToken::class);
    }
}
