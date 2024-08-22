<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTradeHistory extends Model
{
    protected $table = 'orders_trade_history';
    use HasFactory;

    protected $fillable = [
        'user_id', 'symbol', 'type', 'volume', 'entry_price', 'closing_price', 'profit', 'duration'
    ];
}
