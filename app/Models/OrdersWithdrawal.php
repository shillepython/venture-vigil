<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'amount',
        'disbursement'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
