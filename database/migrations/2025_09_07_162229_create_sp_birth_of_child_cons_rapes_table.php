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
        Schema::create('sp_birth_of_child_cons_rape_reqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solo_parent_record_id');
            $table->foreign('solo_parent_record_id')->references('id')->on('solo_parent_records')->onDelete('cascade');
            $table->enum('birth_certificates_of_the_child_or_children', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('birth_certificates_of_the_child_or_children_expires_at')->nullable();
            $table->date('birth_certificates_of_the_child_or_children_updated_at')->nullable();
            $table->enum('complaint_affidavit', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('complaint_affidavit_expires_at')->nullable();
            $table->date('complaint_affidavit_updated_at')->nullable();
            $table->enum('medical_record_on_the_incident_of_rape', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('medical_record_on_the_incident_of_rape_expires_at')->nullable();
            $table->date('medical_record_on_the_incident_of_rape_updated_at')->nullable();
            $table->enum('solo_parent_has_sole_parental_care_of_a_child', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('solo_parent_has_sole_parental_care_of_a_child_expires_at')->nullable();
            $table->date('solo_parent_has_sole_parental_care_of_a_child_updated_at')->nullable();
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
        Schema::dropIfExists('sp_birth_of_child_cons_rape_reqs');
    }
};
