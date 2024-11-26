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
        Schema::create('fitness_activities', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('activity_type'); 
            $table->date('activity_date'); 
            $table->string('name')->nullable();
            $table->json('properties')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_activities');
    }
};
