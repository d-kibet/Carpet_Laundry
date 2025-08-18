<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            [
                'name' => 'Cleaning Supplies',
                'icon_class' => 'fas fa-soap',
                'color_code' => '#28a745',
                'budget_limit' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Maintenance & Repairs',
                'icon_class' => 'fas fa-tools',
                'color_code' => '#fd7e14',
                'budget_limit' => null,
                'requires_approval' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Transportation',
                'icon_class' => 'fas fa-car',
                'color_code' => '#007bff',
                'budget_limit' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'Employee Expenses',
                'icon_class' => 'fas fa-user-tie',
                'color_code' => '#6f42c1',
                'budget_limit' => null,
                'requires_approval' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Equipment & Machinery',
                'icon_class' => 'fas fa-cogs',
                'color_code' => '#6c757d',
                'budget_limit' => null,
                'requires_approval' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Utilities & Services',
                'icon_class' => 'fas fa-bolt',
                'color_code' => '#ffc107',
                'budget_limit' => null,
                'sort_order' => 6,
            ],
            [
                'name' => 'Office Supplies',
                'icon_class' => 'fas fa-paperclip',
                'color_code' => '#17a2b8',
                'budget_limit' => null,
                'sort_order' => 7,
            ],
            [
                'name' => 'Marketing & Advertising',
                'icon_class' => 'fas fa-bullhorn',
                'color_code' => '#e83e8c',
                'budget_limit' => null,
                'sort_order' => 8,
            ],
            [
                'name' => 'Other Expenses',
                'icon_class' => 'fas fa-ellipsis-h',
                'color_code' => '#6c757d',
                'budget_limit' => null,
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('expense_categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('expense_categories')->truncate();
    }
};