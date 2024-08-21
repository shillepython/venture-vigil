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
        Schema::create('trading_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('symbol'); // Символ актива, например "USD/EUR"
            $table->enum('type', ['buy', 'sell']); // Тип ордера
            $table->decimal('volume', 15, 8); // Объем сделки
            $table->decimal('entry_price', 15, 8); // Цена входа
            $table->decimal('current_price', 15, 8)->nullable(); // Текущая цена (можно оставить nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_orders');
    }
};
