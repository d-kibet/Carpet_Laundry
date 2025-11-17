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
        Schema::table('sms_logs', function (Blueprint $table) {
            // Add delivery tracking fields
            $table->string('delivery_status')->default('pending')->after('status');
            // pending, submitted, delivered, failed, undelivered, rejected, expired
            $table->timestamp('delivered_at')->nullable()->after('sent_at');
            $table->text('delivery_report')->nullable()->after('error_message');
            $table->string('network_status')->nullable()->after('delivery_status');
            // Network status codes from Roberms

            $table->index('delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->dropIndex(['delivery_status']);
            $table->dropColumn(['delivery_status', 'delivered_at', 'delivery_report', 'network_status']);
        });
    }
};
