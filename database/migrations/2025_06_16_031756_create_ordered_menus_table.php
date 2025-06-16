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
        Schema::create('ordered_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->foreignId('reservation_id')
                  ->references('id')
                  ->on('reservations');
            $table->foreignId('menu_id')
                  ->references('id')
                  ->on('menus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordered_menus');
    }
};
