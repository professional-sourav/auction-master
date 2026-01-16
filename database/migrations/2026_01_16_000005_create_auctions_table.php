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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('type')->index();
            $table->string('status')->default('draft')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->decimal('starting_price', 12, 2);
            $table->decimal('min_increment', 12, 2);
            $table->decimal('reserve_price', 12, 2)->nullable();
            $table->decimal('buy_now_price', 12, 2)->nullable();
            $table->timestamps();

            $table->index(['status', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
