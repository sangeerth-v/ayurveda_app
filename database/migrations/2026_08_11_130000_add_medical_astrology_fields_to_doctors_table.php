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
            if (!Schema::hasColumn('doctors', 'knows_medical_astrology')) {
                $table->boolean('knows_medical_astrology')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('doctors', 'astrology_details')) {
                $table->text('astrology_details')->nullable()->after('knows_medical_astrology');
            }
            if (!Schema::hasColumn('doctors', 'astrology_qualification')) {
                $table->string('astrology_qualification')->nullable()->after('astrology_details');
            }
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
            $table->dropColumn(['knows_medical_astrology', 'astrology_details', 'astrology_qualification']);
        });
    }
};
