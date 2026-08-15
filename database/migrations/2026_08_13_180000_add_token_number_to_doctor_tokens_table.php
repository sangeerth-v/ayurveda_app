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
        if (!Schema::hasColumn('doctor_tokens', 'token_number')) {
            Schema::table('doctor_tokens', function (Blueprint $table) {
                $table->integer('token_number')->nullable()->after('doctor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('doctor_tokens', 'token_number')) {
            Schema::table('doctor_tokens', function (Blueprint $table) {
                $table->dropColumn('token_number');
            });
        }
    }
};
