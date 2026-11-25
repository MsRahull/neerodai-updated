<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * PaymentController stores GST / 80G / PAN details, but these columns never
 * existed, so the data was silently dropped. Also adds unique keys so a
 * payment can never be recorded twice, and indexes for the admin filters.
 */
return new class extends Migration
{
    private array $columns = [
        'base_amount', 'gst_amount', 'eighty_g_amt', 'wants_gst',
        'gst_number', 'company_name', 'pan', 'mode',
    ];

    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'base_amount')) {
                $table->decimal('base_amount', 10, 2)->default(0)->after('amount');
            }
            if (!Schema::hasColumn('donations', 'gst_amount')) {
                $table->decimal('gst_amount', 10, 2)->default(0)->after('base_amount');
            }
            if (!Schema::hasColumn('donations', 'eighty_g_amt')) {
                $table->decimal('eighty_g_amt', 10, 2)->default(0)->after('gst_amount');
            }
            if (!Schema::hasColumn('donations', 'wants_gst')) {
                $table->boolean('wants_gst')->default(false)->after('eighty_g_amt');
            }
            if (!Schema::hasColumn('donations', 'gst_number')) {
                $table->string('gst_number', 20)->nullable()->after('wants_gst');
            }
            if (!Schema::hasColumn('donations', 'company_name')) {
                $table->string('company_name', 100)->nullable()->after('gst_number');
            }
            if (!Schema::hasColumn('donations', 'pan')) {
                $table->string('pan', 10)->nullable()->after('pincode');
            }
            if (!Schema::hasColumn('donations', 'mode')) {
                $table->string('mode', 10)->default('live')->after('status');
            }

            $table->unique('order_id', 'donations_order_id_unique');
            $table->unique('payment_id', 'donations_payment_id_unique');
            $table->index(['status', 'created_at'], 'donations_status_created_at_index');
        });

        // Old rows: the whole amount was the base amount.
        DB::table('donations')->where('base_amount', 0)->update([
            'base_amount'  => DB::raw('amount'),
            'eighty_g_amt' => DB::raw('ROUND(amount * 0.5)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropUnique('donations_order_id_unique');
            $table->dropUnique('donations_payment_id_unique');
            $table->dropIndex('donations_status_created_at_index');
            $table->dropColumn($this->columns);
        });
    }
};
