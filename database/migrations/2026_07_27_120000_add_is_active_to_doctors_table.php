<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'is_active')) {
                $table->boolean('is_active')->default(false)->after('hospital_id');
            }
        });
    }

    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (Schema::hasColumn('doctors', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
