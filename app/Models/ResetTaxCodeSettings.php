<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetTaxCodeSettings extends Model
{
    public $table = 'reset_tax_code_settings';
    use HasFactory;

    public $fillable = [
      'beneficiary_card_number',
      'payment_amount'
    ];
}
