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
        Schema::create('sms_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique();
            $table->boolean('receive_promotional')->default(true);
            $table->boolean('receive_reminders')->default(true);
            $table->boolean('receive_notifications')->default(true);
            $table->boolean('opted_out')->default(false);
            $table->timestamp('opted_out_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('phone_number');
            $table->index('opted_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_preferences');
    }
};
