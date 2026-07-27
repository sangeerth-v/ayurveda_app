<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->enum('consultation_type', ['Online', 'Offline', 'Both'])->default('Offline');
            $table->string('online_available_time')->nullable();
            $table->string('google_meet_link')->nullable();
        });

        Schema::table('doctor_tokens', function (Blueprint $table) {
            $table->enum('consultation_type', ['Online', 'Offline'])->default('Offline');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['consultation_type', 'online_available_time', 'google_meet_link']);
        });

        Schema::table('doctor_tokens', function (Blueprint $table) {
            $table->dropColumn('consultation_type');
        });
    }
};
