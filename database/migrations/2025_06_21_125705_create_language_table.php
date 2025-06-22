<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('code')->unique();
            $table->string('locale')->unique();
            $table->boolean('default')->default(false);
        });
        \Illuminate\Support\Facades\DB::statement("
        INSERT INTO `languages` (`id`, `title`, `code`, `locale`, `default`) VALUES
(1, 'Ukrainian', 'uk', 'uk_UA', 0),
(2, 'English', 'en', 'en_us', 1);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
