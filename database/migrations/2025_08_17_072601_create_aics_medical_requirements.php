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
        Schema::create('aics_medical_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_record_id');
            $table->foreign('aics_record_id')->references('id')->on('aics_records')->onDelete('cascade');
            $table->enum('letter_to_the_mayor', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('letter_to_the_mayor_expires_at')->nullable();
            $table->date('letter_to_the_mayor_updated_at')->nullable();
            $table->enum('medical_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('medical_certificate_expires_at')->nullable();
            $table->date('medical_certificate_updated_at')->nullable();
            $table->enum('laboratory_or_prescription', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('laboratory_or_prescription_expires_at')->nullable();
            $table->date('laboratory_or_prescription_updated_at')->nullable();
            $table->enum('barangay_indigency', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('barangay_indigency_expires_at')->nullable();
            $table->date('barangay_indigency_updated_at')->nullable();
            $table->enum('valid_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('valid_id_expires_at')->nullable();
            $table->date('valid_id_updated_at')->nullable();
            $table->enum('cedula', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('cedula_expires_at')->nullable();
            $table->date('cedula_updated_at')->nullable();
            $table->enum('barangay_certificate_or_marriage_contract', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('barangay_certificate_or_marriage_contract_expires_at')->nullable();
            $table->date('barangay_certificate_or_marriage_contract_updated_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('user_role');
            $table->string('user_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aics_medical_requirements');
    }
};
