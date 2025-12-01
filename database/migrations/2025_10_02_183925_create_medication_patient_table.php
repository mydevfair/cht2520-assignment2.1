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
        Schema::create('medication_patient', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');

            $table->string('frequency');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('instructions')->nullable();

            $table->timestamps();

            $table->index('medication_id');
            $table->index('patient_id');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_patient');
    }
};
