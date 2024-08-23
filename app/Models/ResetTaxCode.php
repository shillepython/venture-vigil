<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetTaxCode extends Model
{
    public $table = 'reset_tax_code';
    use HasFactory;

    public $fillable = [
      'user_id',
      'receipt_path'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
