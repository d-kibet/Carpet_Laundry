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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('expense_categories');
            $table->string('subcategory')->nullable();
            $table->string('vendor_name');
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->enum('payment_method', ['Cash', 'M-Pesa', 'Bank Transfer', 'Cheque'])->default('Cash');
            $table->string('transaction_reference')->nullable();
            $table->string('receipt_image')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->enum('approval_status', ['Pending', 'Approved', 'Rejected'])->default('Approved');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};