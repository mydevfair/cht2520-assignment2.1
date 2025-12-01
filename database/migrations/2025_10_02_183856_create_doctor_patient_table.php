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
        Schema::create('doctor_patient', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');

            $table->date('assignment_date')->default(now());
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['doctor_id', 'patient_id']);

            $table->index('doctor_id');
            $table->index('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_patient');
    }
};
