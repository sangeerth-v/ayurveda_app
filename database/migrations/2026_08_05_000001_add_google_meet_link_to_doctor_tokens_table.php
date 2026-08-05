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
        Schema::table('doctor_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_tokens', 'google_meet_link')) {
                $table->string('google_meet_link', 500)->nullable()->after('consultation_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('doctor_tokens', 'google_meet_link')) {
                $table->dropColumn('google_meet_link');
            }
        });
    }
};
