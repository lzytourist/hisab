<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_id',
        'title',
        'details',
        'amount'
    ];

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class, 'method_id', 'id');
    }
}
