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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('phone_number');
            $table->text('message');
            $table->string('type')->default('manual'); // manual, automated, bulk, scheduled
            $table->string('category')->nullable(); // welcome, reminder, promotional, etc.
            $table->string('status')->default('pending'); // pending, sent, failed
            $table->string('unique_identifier')->nullable();
            $table->text('response_data')->nullable();
            $table->string('related_type')->nullable(); // App\Models\Carpet, App\Models\Laundry
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['phone_number', 'created_at']);
            $table->index('status');
            $table->index('type');
            $table->index(['related_type', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
