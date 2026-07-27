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
            if (!Schema::hasColumn('doctors', 'medical_registration_no')) {
                $table->string('medical_registration_no')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('doctors', 'address')) {
                $table->text('address')->nullable()->after('district_id');
            }
            if (!Schema::hasColumn('doctors', 'registration_certificate')) {
                $table->string('registration_certificate')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('doctors', 'council_certificate')) {
                $table->string('council_certificate')->nullable()->after('registration_certificate');
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
            $table->dropColumn([
                'medical_registration_no',
                'address',
                'registration_certificate',
                'council_certificate',
            ]);
        });
    }
};
