<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Зв'язок з користувачем
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Основні поля для LiqPay
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('UAH');
            $table->string('description');

            // Дані для генерації платежу
            $table->text('liqpay_data')->nullable();
            $table->string('liqpay_signature')->nullable();

            // Callback поля
            $table->string('status')->default('created'); // created | success | failure
            $table->string('payment_type')->nullable();
            $table->string('liqpay_order_id')->nullable();
            $table->boolean('is_test')->default(false);
            $table->timestamp('paid_at')->nullable();

            // Журнал
            $table->text('server_response')->nullable();
            $table->string('fail_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
