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
        Schema::table('dns', function (Blueprint $table) {
            // Change dn_number from text to string and add unique constraint
            $table->string('dn_number')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dns', function (Blueprint $table) {
            // Revert back to text without unique constraint
            $table->text('dn_number')->change();
            $table->dropUnique(['dn_number']);
        });
    }
};
