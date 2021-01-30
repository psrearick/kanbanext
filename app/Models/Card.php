<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['title', 'description', 'column_id', 'user_id', 'active'];

    protected $casts = [
        'column_id' => 'integer',
        'user_id' => 'integer',
        'active' => 'boolean'
    ];
}
