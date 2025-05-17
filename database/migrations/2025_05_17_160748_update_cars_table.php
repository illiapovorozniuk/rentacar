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
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('car_brand_id')->after('car_model_id');
            $table->integer('car_body_type_id')->after('car_brand_id');
            $table->string('car_slug')->after('car_body_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('car_brand_id');
            $table->dropColumn('car_body_type_id');
            $table->dropColumn('car_slug');
        });
    }
};
