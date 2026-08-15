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

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function pharmaCompany()
    {
        return $this->belongsTo(PharmaCompany::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->latest();
    }

    public function getAverageRatingAttribute()
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round($avg, 1) : 4.8;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
