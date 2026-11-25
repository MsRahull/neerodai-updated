<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The blogs table was created by hand on the server (no migration existed).
 * This migration creates it on a fresh install, and on existing databases:
 *  - adds `language` (both | en | ta): which language versions the post has
 *  - makes English fields nullable so a Tamil-only post is possible
 *  - aligns the id / collation with the rest of the schema
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->enum('language', ['both', 'en', 'ta'])->default('both');
                $table->string('title')->nullable();
                $table->string('title_tamil')->nullable();
                $table->string('slug')->unique();
                $table->text('short_description')->nullable();
                $table->text('short_description_tamil')->nullable();
                $table->longText('content')->nullable();
                $table->longText('content_tamil')->nullable();
                $table->string('image')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->boolean('homeflag')->default(false);
                $table->timestamps();
                $table->index(['status', 'homeflag', 'created_at']);
            });

            return;
        }

        if (!Schema::hasColumn('blogs', 'language')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->enum('language', ['both', 'en', 'ta'])->default('both')->after('id');
            });
            // Existing posts only had English text.
            DB::table('blogs')->update(['language' => 'en']);
            DB::table('blogs')
                ->whereNotNull('title_tamil')->where('title_tamil', '!=', '')
                ->whereNotNull('content_tamil')->where('content_tamil', '!=', '')
                ->update(['language' => 'both']);
        }

        // MySQL / MariaDB only (the project's database). No doctrine/dbal needed.
        DB::statement('ALTER TABLE blogs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE blogs
            MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            MODIFY title VARCHAR(255) NULL,
            MODIFY content LONGTEXT NULL');

        $indexes = collect(DB::select('SHOW INDEX FROM blogs'))->pluck('Key_name');
        if (!$indexes->contains('blogs_status_homeflag_created_at_index')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->index(['status', 'homeflag', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('blogs', 'language')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropIndex(['status', 'homeflag', 'created_at']);
                $table->dropColumn('language');
            });
        }
    }
};
