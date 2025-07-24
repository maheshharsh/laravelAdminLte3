
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
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('path');
            $table->string('disk')->default('public');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
             $table->foreignId('article_id')
                  ->constrained('articles')
                  ->onDelete('cascade')
                  ->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
