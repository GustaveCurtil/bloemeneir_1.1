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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->date('last_order_date')->nullable();
            $table->time('last_order_time')->nullable();
            $table->date('takeaway_date');
            $table->time('takeaway_start_time')->nullable();
            $table->time('takeaway_end_time')->nullable();
            $table->boolean('is_public')->default(false);
            $table->string('emoji')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
