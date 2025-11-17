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
        Schema::table('carpets', function (Blueprint $table) {
            $table->timestamp('last_overdue_notification_at')->nullable()->after('resolved_at');
        });

        Schema::table('laundries', function (Blueprint $table) {
            $table->timestamp('last_overdue_notification_at')->nullable()->after('resolved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carpets', function (Blueprint $table) {
            $table->dropColumn('last_overdue_notification_at');
        });

        Schema::table('laundries', function (Blueprint $table) {
            $table->dropColumn('last_overdue_notification_at');
        });
    }
};
