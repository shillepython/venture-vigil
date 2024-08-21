<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'symbol',
        'type',
        'volume',
        'entry_price',
        'current_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
