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
        Schema::create('videosurl', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['video', 'youtube'])->default('video'); 
            $table->string('video')->nullable();        // for uploaded video
            $table->string('youtube_url')->nullable();  // for YouTube link
            $table->boolean('videoflag')->default(0);   // like your imageflag
            $table->boolean('homeflag')->default(0);    // like your homeflag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videosurl');
    }
};
