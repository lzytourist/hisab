<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'amount',
        'method_id'
    ];

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class, 'method_id', 'id');
    }
}
