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
        Schema::create('senior_citizen_records', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('house_no_unit_floor')->nullable();
            $table->string('street')->nullable();
            $table->enum('barangay', ['Bangkal', 'Calaylayan', 'Capitangan', 'Gabon', 'Laon', 'Mabatang', 'Omboy', 'Salian', 'Wawa']);
            $table->string('city_municipality')->default('Abucay');
            $table->string('province')->default('Bataan');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->unsignedBigInteger('age');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed', 'Separated']);
            $table->enum('educational_attainment', ['No Formal Education', 'Elementary Undergraduate', 'Elementary Graduate', 'High School Undergraduate', 'High School Graduate', 'Vocational Graduate', 'College Undergraduate', 'College Graduate', 'Post Graduate']);
            $table->string('occupation');
            $table->string('cellphone_number');
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
        Schema::dropIfExists('senior_citizen_records');
    }
};
