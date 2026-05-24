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
        Schema::create('master_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('creative_activities')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->enum('time_slot', ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00']);
            $table->integer('capacity');
            $table->decimal('cost', 8, 2);
            $table->timestamps();
            
            $table->unique(['date', 'time_slot']); // Prevent overlapping across any rooms/instructors based on FR-008
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_classes');
    }
};
