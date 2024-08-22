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
        Schema::create('orders_trade_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('symbol');
            $table->string('type');
            $table->decimal('volume', 15, 8);
            $table->decimal('entry_price', 15, 8);
            $table->decimal('closing_price', 15, 8);
            $table->decimal('profit', 15, 8);
            $table->integer('duration'); // продолжительность в минутах
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_trade_history');
    }
};
