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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('date_id')->nullable()->constrained('dates')->cascadeOnDelete();
            $table->date('takeaway_date')->nullable();
            $table->time('takeaway_start_time')->nullable();
            $table->time('takeaway_end_time')->nullable();
            $table->boolean('is_collected')->nullable();
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
