<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PharmaCompany extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'company_name',
        'email',
        'password',
        'password_plain',
        'phone',
        'drug_license_no',
        'gst_number',
        'contact_person',
        'address',
        'district_id',
        'logo',
        'license_document',
        'is_active',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
