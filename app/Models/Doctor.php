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
        'phone',
        'department_id',
        'district_id',
        'qualification',
        'experience',
        'consultation_fee',
        'available_time',
        'status', // Assuming added later or handled differently, but good to have in fillable if needed. Wait, migration didn't have status. I'll stick to known fields.
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
