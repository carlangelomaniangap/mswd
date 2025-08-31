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
        Schema::create('solo_parent_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solo_parent_record_id');
            $table->foreign('solo_parent_record_id')->references('id')->on('solo_parent_records')->onDelete('cascade');
            $table->enum('valid_id', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->datetime('valid_id_expires_at')->nullable();
            $table->datetime('valid_id_updated_at')->nullable();
            $table->enum('birth_certificate', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->datetime('birth_certificate_expires_at')->nullable();
            $table->datetime('birth_certificate_updated_at')->nullable();
            $table->enum('solo_parent_id_application_form', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->datetime('solo_parent_id_application_form_expires_at')->nullable();
            $table->datetime('solo_parent_id_application_form_updated_at')->nullable();
            $table->enum('affidavit_of_solo_parent', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->datetime('affidavit_of_solo_parent_expires_at')->nullable();
            $table->datetime('affidavit_of_solo_parent_updated_at')->nullable();
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
        Schema::dropIfExists('solo_parent_requirements');
    }
};
