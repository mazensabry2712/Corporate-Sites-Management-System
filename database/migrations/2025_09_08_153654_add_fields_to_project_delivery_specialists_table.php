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
        Schema::table('project_delivery_specialists', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('ds_id')->constrained('ds')->onDelete('cascade');
            $table->boolean('is_lead')->default(false);
            $table->string('responsibility')->nullable();
            $table->decimal('allocation_percentage', 5, 2)->nullable();
            $table->date('assigned_date')->nullable();
            $table->text('notes')->nullable();

            // Add unique constraint to prevent duplicate assignments
            $table->unique(['project_id', 'ds_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_delivery_specialists', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['ds_id']);
            $table->dropColumn([
                'project_id', 'ds_id', 'is_lead', 'responsibility',
                'allocation_percentage', 'assigned_date', 'notes'
            ]);
        });
    }
};
