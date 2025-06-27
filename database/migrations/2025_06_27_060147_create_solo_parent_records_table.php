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
        Schema::create('solo_parent_records', function (Blueprint $table) {
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
            $table->string('religion');
            $table->unsignedBigInteger('philsys_card_number');
            $table->enum('educational_attainment', ['No Formal Education', 'Elementary Undergraduate', 'Elementary Graduate', 'High School Undergraduate', 'High School Graduate', 'Vocational Graduate', 'College Undergraduate', 'College Graduate', 'Post Graduate']);
            $table->enum('employment_status', ['Employed', 'Unemployed', 'Self-Employed', 'Retired']);
            $table->string('occupation');
            $table->string('company_agency');
            $table->unsignedBigInteger('monthly_income');
            $table->string('cellphone_number');
            $table->unsignedBigInteger('number_of_children');
            $table->enum('pantawid_beneficiary', ['Yes', 'No']);
            $table->string('household_id')->nullable();
            $table->enum('indigenous_person', ['Yes', 'No']);
            $table->string('name_of_affliation')->nullable();
            $table->string('emerg_first_name');
            $table->string('emerg_middle_name')->nullable();
            $table->string('emerg_last_name');
            $table->string('emerg_address');
            $table->string('relationship_to_solo_parent');
            $table->string('emerg_contact_number');
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
        Schema::dropIfExists('solo_parent_records');
    }
};
