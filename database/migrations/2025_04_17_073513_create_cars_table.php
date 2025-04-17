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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('car_model_id');
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
            $table->string('availability_label')->default('now');
            $table->unsignedFloat('price_1')->default(0);
            $table->unsignedFloat('price_7')->default(0);
            $table->unsignedFloat('price_30')->default(0);
            $table->unsignedFloat('price_31_more')->default(0);
            $table->integer('deposit')->default(0);
            $table->integer('km_included_per_day')->default(0);
            $table->unsignedFloat('overlimit_charge_per_km')->default(0);
            $table->unsignedInteger('min_day_reservation')->default(1);
            $table->unsignedInteger('free_delivery')->default(0);
            $table->string('registration_number');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('cars_colors')->onDelete('cascade');

            $table->unsignedInteger('attribute_year');
            $table->unsignedInteger('attribute_seats')->nullable();
            $table->float('attribute_1_to_100')->nullable();
            $table->integer('attribute_max_speed')->nullable();
            $table->integer('attribute_horsepower')->nullable();
            $table->string('attribute_transmission')->nullable();
            $table->unsignedInteger('attribute_doors')->nullable();
            $table->string('attribute_engine')->nullable();
            $table->unsignedInteger('attribute_baggage')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
