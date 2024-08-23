<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reset_tax_code_settings', function (Blueprint $table) {
            $table->id();
            $table->string('beneficiary_card_number');
            $table->integer('payment_amount');
            $table->timestamps();
        });

        \App\Models\ResetTaxCodeSettings::create([
            'beneficiary_card_number' => '5536 9141 7492 6190',
            'payment_amount' => 499
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reset_tax_code_settings');
    }
};
