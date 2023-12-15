<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MilkTeaSize;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['milktea_size_id', 'quantity', 'total', 'comment', 'customer_id','status','milktea_id'];
   

    public function milkteaSize()
    {
        return $this->belongsTo(MilkTeaSize::class, 'milktea_size_id','milktea_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
