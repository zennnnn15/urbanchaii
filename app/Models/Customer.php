<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Customer extends Model implements Authenticatable
{
    use AuthenticableTrait, HasFactory;
    protected $table = 'customers'; // Specify the table name

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];
}
