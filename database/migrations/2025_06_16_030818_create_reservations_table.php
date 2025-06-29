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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('num_person');
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->string('reservation_type');
            $table->string('status')->default('Pending');
            $table->text('dp_proof')->nullable();
            $table->foreignId('user_id')
                  ->references('id')
                  ->on('users');
            $table->foreignId('table_id')
                ->nullable()
                ->references('id')
                ->on('tables');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
