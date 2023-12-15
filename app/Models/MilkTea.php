<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkTea extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'milktea_category_id','image'];

    public function category()
    {
        return $this->belongsTo(MilkTeaCategory::class, 'milktea_category_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(MilkTeaSize::class, 'milktea_size_milktea');
    }
}
