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
        Schema::create('aics_burial_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_record_id');
            $table->foreign('aics_record_id')->references('id')->on('aics_records')->onDelete('cascade');
            $table->enum('brgy_cert_of_indigency', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('brgy_cert_of_indigency_expires_at')->nullable();
            $table->date('brgy_cert_of_indigency_updated_at')->nullable();
            $table->enum('death_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('death_certificate_expires_at')->nullable();
            $table->date('death_certificate_updated_at')->nullable();
            $table->enum('proof_of_billing_or_promissory_note_from_funeral', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('proof_of_billing_or_promissory_note_from_funeral_expires_at')->nullable();
            $table->date('proof_of_billing_or_promissory_note_from_funeral_updated_at')->nullable();
            $table->enum('marriage_cert_or_birth_cert_or_cert_of_cohabitation', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('marriage_cert_or_birth_cert_or_cert_of_cohabitation_expires_at')->nullable();
            $table->date('marriage_cert_or_birth_cert_or_cert_of_cohabitation_updated_at')->nullable();
            $table->enum('photocopy_of_valid_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('photocopy_of_valid_id_expires_at')->nullable();
            $table->date('photocopy_of_valid_id_updated_at')->nullable();
            $table->enum('surrender_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('surrender_id_expires_at')->nullable();
            $table->date('surrender_id_updated_at')->nullable();
            $table->enum('personal_letter', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('personal_letter_expires_at')->nullable();
            $table->date('personal_letter_updated_at')->nullable();
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
        Schema::dropIfExists('aics_burial_requirements');
    }
};
