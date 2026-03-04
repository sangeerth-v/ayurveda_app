<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSubcategory extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(DoctorCategory::class, 'doctor_category_id');
    }
}
