<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Product extends Model
{
    use HasFactory;

    protected $table = 'Purchase_Products';
    protected $guaeded = ['id'];
}
