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
            $table->enum('solo_parent_category', ['Birth of a child as a consequence of rape','Widow/widower','Spouse of person deprived of liberty','Spouse of person with physical or mental incapacity','Due to legal separation or de facto separation','Due to nullity or annulment of marriage','Abandonment by the spouse','Spouse of OFW','Relative of OFW','Unmarried person','Legal guardian/Adoptive parent/Foster parent','Relative within the fourth (4th) civil degree of consanguinity or affinity','Pregnant woman']);
            $table->string('emerg_first_name');
            $table->string('emerg_middle_name')->nullable();
            $table->string('emerg_last_name');
            $table->string('emerg_address');
            $table->string('relationship_to_solo_parent');
            $table->string('emerg_contact_number');
            $table->string('qr_code');
            $table->enum('status', ['Eligible', 'In Progress', 'Expired', 'Not Eligible'])->default('In Progress');
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
