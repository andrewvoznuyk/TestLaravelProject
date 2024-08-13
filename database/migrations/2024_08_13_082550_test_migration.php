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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('phone_number')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('is_active')->default(true);

            // If you need to rename a column or change a column type
            // $table->renameColumn('old_name', 'new_name');
            // $table->integer('column_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn('phone_number');
            $table->dropColumn('age');
            $table->dropColumn('is_active');

            // If you need to revert changes like renaming or changing column type
            // $table->renameColumn('new_name', 'old_name');
            // $table->string('column_name')->change();
        });
    }
};
