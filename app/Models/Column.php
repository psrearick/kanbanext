<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Column extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'active'];

    /**
     * @var string[]
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
