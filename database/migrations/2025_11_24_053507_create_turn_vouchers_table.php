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
        Schema::create('turn_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->tinyInteger('option1')->nullable();
            $table->tinyInteger('option1_original')->nullable();
            $table->tinyInteger('option2')->nullable();
            $table->tinyInteger('option2_original')->nullable();
            $table->tinyInteger('option3')->nullable();
            $table->tinyInteger('option3_original')->nullable();
            $table->date('valid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turn_vouchers');
    }
};
