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
        Schema::create('aics_family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_record_id');
            $table->foreign('aics_record_id')->references('id')->on('aics_records')->onDelete('cascade');
            $table->string('family_member_name');
            $table->enum('relationship', [
                'Great-grandfather', 'Great-grandmother', 'Great-grandson', 'Great-granddaughter',
                'GrandFather', 'GrandMother', 'Grandson', 'Granddaughter',
                'Father', 'Mother', 'Spouse', 'Uncle', 'Auntie', 'Brother', 'Sister',
                'Son', 'Daughter', 'Nephew', 'Niece', 'Cousin',
                'Father-in-law', 'Mother-in-law', 'Brother-in-law', 'Sister-in-law',
                'Son-in-law', 'Daughter-in-law',
                'Stepfather', 'Stepmother', 'Stepbrother', 'Stepsister',
                'Half-brother', 'Half-sister'
            ]);
            $table->unsignedTinyInteger('family_member_age');
            $table->enum('family_member_status', ['eligible']);
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
        Schema::dropIfExists('aics_family_members');
    }
};
