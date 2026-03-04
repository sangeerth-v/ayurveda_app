<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subcategories()
    {
        return $this->hasMany(DoctorSubcategory::class);
    }
}
