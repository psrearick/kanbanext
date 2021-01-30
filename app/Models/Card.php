<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'column_id', 'user_id', 'active', 'rank'];

    /**
     * @var string[]
     */
    protected $casts = [
        'column_id' => 'integer',
        'user_id' => 'integer',
        'active' => 'boolean',
        'rank' => 'float'
    ];

    /**
     * @return BelongsTo
     */
    public function Column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
