<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkTeaSize extends Model
{
    use HasFactory;
    protected $table = 'milk_tea_sizes';

    protected $fillable = ['name', 'price'];
    
    public function milkTeas()
    {
        return $this->belongsToMany(MilkTea::class, 'milktea_size_milktea', 'milktea_id', 'milktea_size_id');
    }

    
}
