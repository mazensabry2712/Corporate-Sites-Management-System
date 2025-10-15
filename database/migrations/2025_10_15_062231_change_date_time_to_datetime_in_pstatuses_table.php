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
        Schema::table('pstatuses', function (Blueprint $table) {
            // تغيير نوع الحقل من date إلى datetime
            $table->dateTime('date_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pstatuses', function (Blueprint $table) {
            // الرجوع إلى date
            $table->date('date_time')->nullable()->change();
        });
    }
};
