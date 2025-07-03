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
        Schema::create('aics_payout_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_record_id_payout');
            $table->foreign('aics_record_id_payout')->references('id')->on('aics_records')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->string('type');
            $table->string('claimed_by');
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
        Schema::dropIfExists('aics_payout_histories');
    }
};
