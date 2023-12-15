<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkTeaCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','updated_at','id'];

    public function milkTeas()
    {
        return $this->hasMany(MilkTea::class);
    }
}
