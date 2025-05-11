<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PageType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->jsonb('title');
            $table->string('link')->unique();
            $table->string('type')->default(PageType::PAGE->value);
            $table->jsonb('h1')->nullable();
            $table->jsonb('description');
            $table->jsonb('content')->nullable();
            $table->boolean('enabled')->default(0);
            $table->longText('faq')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
