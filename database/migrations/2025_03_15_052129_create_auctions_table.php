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
            $table->foreignId('fish_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user yang membuat lelang (pedagang)
            $table->decimal('start_price', 12, 2);
            $table->decimal('current_price', 12, 2);
            $table->decimal('min_bid', 12, 2)->default(10000); // minimal kenaikan bid
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', ['upcoming', 'active', 'ended', 'cancelled'])->default('upcoming');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
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
