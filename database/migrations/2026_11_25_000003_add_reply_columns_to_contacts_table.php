<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tracks admin replies to contact messages (sent by Email or WhatsApp
 * from the admin Customers page).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('message');
            }
            if (!Schema::hasColumn('contacts', 'replied_via')) {
                $table->string('replied_via', 20)->nullable()->after('replied_at'); // email | whatsapp
            }
            if (!Schema::hasColumn('contacts', 'reply_count')) {
                $table->unsignedInteger('reply_count')->default(0)->after('replied_via');
            }
            $table->index('created_at', 'contacts_created_at_index');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_created_at_index');
            $table->dropColumn(['replied_at', 'replied_via', 'reply_count']);
        });
    }
};
