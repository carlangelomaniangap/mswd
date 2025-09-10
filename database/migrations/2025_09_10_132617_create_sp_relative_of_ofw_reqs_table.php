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
        Schema::create('sp_relative_of_ofw_reqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solo_parent_record_id');
            $table->foreign('solo_parent_record_id')->references('id')->on('solo_parent_records')->onDelete('cascade');
            $table->enum('birth_certificates_of_dependents', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('birth_certificates_of_dependents_expires_at')->nullable();
            $table->date('birth_certificates_of_dependents_updated_at')->nullable();
            $table->enum('marriage_certificate_ofw', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('marriage_certificate_ofw_expires_at')->nullable();
            $table->date('marriage_certificate_ofw_updated_at')->nullable();
            $table->enum('ph_overseas_employment', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('ph_overseas_employment_expires_at')->nullable();
            $table->date('ph_overseas_employment_updated_at')->nullable();
            $table->enum('photocopy_of_ofw_passport', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('photocopy_of_ofw_passport_expires_at')->nullable();
            $table->date('photocopy_of_ofw_passport_updated_at')->nullable();
            $table->enum('proof_of_income', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('proof_of_income_expires_at')->nullable();
            $table->date('proof_of_income_updated_at')->nullable();
            $table->enum('b1_2_solo_parent_not_cohabiting', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('b1_2_solo_parent_not_cohabiting_expires_at')->nullable();
            $table->date('b1_2_solo_parent_not_cohabiting_updated_at')->nullable();
            $table->enum('solo_parent_is_a_resident_of_the_barangay_and_child', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('solo_parent_is_a_resident_of_the_barangay_and_child_expires_at')->nullable();
            $table->date('solo_parent_is_a_resident_of_the_barangay_and_child_updated_at')->nullable();
            $table->enum('solo_parent_orientation_seminar_cert_of_attendance', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('solo_parent_orientation_seminar_cert_of_attendance_expires_at')->nullable();
            $table->date('solo_parent_orientation_seminar_cert_of_attendance_updated_at')->nullable();
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
        Schema::dropIfExists('sp_relative_of_ofw_reqs');
    }
};
