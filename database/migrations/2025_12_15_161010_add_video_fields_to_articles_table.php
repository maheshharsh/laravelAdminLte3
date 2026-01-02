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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('featured_image');
            $table->string('video_thumbnail')->nullable()->after('video_file');
            $table->text('video_description')->nullable()->after('video_thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_thumbnail', 'video_description']);
        });
    }
};
