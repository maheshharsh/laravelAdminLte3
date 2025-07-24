
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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
