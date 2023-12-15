<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkteaSizeMilktea extends Model
{
    use HasFactory;
    protected $table = 'milktea_size_milktea';

    protected $fillable = [
        'milktea_id',
        'milktea_size_id',
    ];
  
    
    // Define relationships with Milktea and MilkteaSize models if needed
    public function milktea()
    {
        return $this->belongsTo(Milktea::class);
    }

    public function milkteaSize()
    {
        return $this->belongsTo(MilkteaSize::class,'milktea_size_id');
    }
}
