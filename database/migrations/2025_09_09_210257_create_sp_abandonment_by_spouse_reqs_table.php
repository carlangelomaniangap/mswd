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
        Schema::create('sp_abandonment_by_spouse_reqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solo_parent_record_id');
            $table->foreign('solo_parent_record_id')->references('id')->on('solo_parent_records')->onDelete('cascade');
            $table->enum('birth_certificates_of_the_child_or_children', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('birth_certificates_of_the_child_or_children_expires_at')->nullable();
            $table->date('birth_certificates_of_the_child_or_children_updated_at')->nullable();
            $table->enum('marriage_certificate_affidavit', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('marriage_certificate_affidavit_expires_at')->nullable();
            $table->date('marriage_certificate_affidavit_updated_at')->nullable();
            $table->enum('abandonment_of_the_spouse', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('abandonment_of_the_spouse_expires_at')->nullable();
            $table->date('abandonment_of_the_spouse_updated_at')->nullable();
            $table->enum('record_of_the_fact_of_abandonment', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('record_of_the_fact_of_abandonment_expires_at')->nullable();
            $table->date('record_of_the_fact_of_abandonment_updated_at')->nullable();
            $table->enum('a7_solo_parent_not_cohabiting', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('a7_solo_parent_not_cohabiting_expires_at')->nullable();
            $table->date('a7_solo_parent_not_cohabiting_updated_at')->nullable();
            $table->enum('solo_parent_is_a_resident', ['Complete', 'Incomplete', 'Renewal', 'Denied'])->default('Incomplete');
            $table->date('solo_parent_is_a_resident_expires_at')->nullable();
            $table->date('solo_parent_is_a_resident_updated_at')->nullable();
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
        Schema::dropIfExists('sp_abandonment_by_spouse_reqs');
    }
};
