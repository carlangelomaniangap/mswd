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
        Schema::create('aics_medical_pasyente_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_record_id');
            $table->foreign('aics_record_id')->references('id')->on('aics_records')->onDelete('cascade');
            $table->enum('personal_letter', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('personal_letter_expires_at')->nullable();
            $table->date('personal_letter_updated_at')->nullable();
            $table->enum('brgy_cert_of_indigency', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('brgy_cert_of_indigency_expires_at')->nullable();
            $table->date('brgy_cert_of_indigency_updated_at')->nullable();
            $table->enum('medical_abstract_or_medical_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('medical_abstract_or_medical_certificate_expires_at')->nullable();
            $table->date('medical_abstract_or_medical_certificate_updated_at')->nullable();
            $table->enum('latest_na_reseta_with_costing', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('latest_na_reseta_with_costing_expires_at')->nullable();
            $table->date('latest_na_reseta_with_costing_updated_at')->nullable();
            $table->enum('latest_na_laboratory_test_with_costing', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('latest_na_laboratory_test_with_costing_expires_at')->nullable();
            $table->date('latest_na_laboratory_test_with_costing_updated_at')->nullable();
            $table->enum('hospital_bill', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('hospital_bill_expires_at')->nullable();
            $table->date('hospital_bill_updated_at')->nullable();
            $table->enum('one_valid_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('one_valid_id_expires_at')->nullable();
            $table->date('one_valid_id_updated_at')->nullable();
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
        Schema::dropIfExists('aics_medical_pasyente_requirements');
    }
};
