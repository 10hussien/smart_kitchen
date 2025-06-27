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
        Schema::create('meal_request_health_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('health_condition_id')->constrained()->onDelete('cascade');
            $table->integer('affected_people_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_request_health_conditions');
    }
};
