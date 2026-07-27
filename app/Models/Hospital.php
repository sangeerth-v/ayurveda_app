<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Hospital extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_plain',
        'phone',
        'license_number',
        'gst_number',
        'contact_person',
        'address',
        'district_id',
        'specialties',
        'treatments',
        'facilities',
        'description',
        'logo',
        'license_document',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function specialtiesList()
    {
        return $this->splitList($this->specialties);
    }

    public function treatmentsList()
    {
        return $this->splitList($this->treatments);
    }

    public function facilitiesList()
    {
        return $this->splitList($this->facilities);
    }

    protected function splitList($value)
    {
        return collect(preg_split('/\r\n|\r|\n|,/', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values();
    }
}
