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
        Schema::create('sp_pregnant_woman_reqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solo_parent_record_id');
            $table->foreign('solo_parent_record_id')->references('id')->on('solo_parent_records')->onDelete('cascade');
            $table->enum('medical_record_of_pregnancy', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('medical_record_of_pregnancy_expires_at')->nullable();
            $table->date('medical_record_of_pregnancy_updated_at')->nullable();
            $table->enum('solo_parent_is_a_resident_of_barangay', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('solo_parent_is_a_resident_of_barangay_expires_at')->nullable();
            $table->date('solo_parent_is_a_resident_of_barangay_updated_at')->nullable();
            $table->enum('f_solo_parent_not_cohabiting', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('f_solo_parent_not_cohabiting_expires_at')->nullable();
            $table->date('f_solo_parent_not_cohabiting_updated_at')->nullable();
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
        Schema::dropIfExists('sp_pregnant_woman_reqs');
    }
};
