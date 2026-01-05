<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\MoneyCast;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'name',
        'amount',
        'currency',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => MoneyCast::class,
    ];

    public function categories()
    {
        return $this->belongsToMany(TransactionCategory::class);
    }
}
