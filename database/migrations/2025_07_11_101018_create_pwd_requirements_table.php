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
        Schema::create('pwd_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pwd_record_id');
            $table->foreign('pwd_record_id')->references('id')->on('pwd_records')->onDelete('cascade');
            $table->enum('valid_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('valid_id_expires_at')->nullable();
            $table->date('valid_id_updated_at')->nullable();
            $table->enum('medical_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('medical_certificate_expires_at')->nullable();
            $table->date('medical_certificate_updated_at')->nullable();
            $table->enum('barangay_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('barangay_certificate_expires_at')->nullable();
            $table->date('barangay_certificate_updated_at')->nullable();
            $table->enum('birth_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('birth_certificate_expires_at')->nullable();
            $table->date('birth_certificate_updated_at')->nullable();
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
        Schema::dropIfExists('pwd_requirements');
    }
};
