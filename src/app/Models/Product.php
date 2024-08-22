<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $timestamps = false;

    protected $casts = [
        'imported_t' => 'datetime',
        'created_t' => 'datetime',
        'last_modified_t' => 'datetime',
        'serving_quantity' => 'float',
        'nutriscore_score' => 'integer',
    ];
}
