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
        Schema::create('car_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->jsonb('name');
            $table->unsignedInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unsignedInteger('body_type_id');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('cascade');
            $table->unsignedTinyInteger('attribute_seats')->nullable();
            $table->float('attribute_1_to_100')->nullable();
            $table->integer('attribute_max_speed')->nullable();
            $table->integer('attribute_horsepower')->nullable();
            $table->string('attribute_transmission')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::create('car_model_type', function (Blueprint $table) {
            $table->unsignedInteger('car_model_id');
            $table->foreign('car_model_id')
                ->references('id')
                ->on('car_models')
                ->onDelete('cascade');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_model_type');
        Schema::dropIfExists('car_models');
    }
};
