<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageData extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'usage',
    ];

    // Rest of your model code...
}
