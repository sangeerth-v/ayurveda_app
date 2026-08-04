<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharma_company_id',
        'doctor_id',
        'name',
        'category',
        'subcategory',
        'description',
        'price',
        'stock',
        'image',
        'expiry_date',
    ];

    public function pharmaCompany()
    {
        return $this->belongsTo(PharmaCompany::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
