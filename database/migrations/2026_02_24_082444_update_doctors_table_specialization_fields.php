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
            // Drop the old department_id foreign key and column
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
            
            // Add new specialization fields
            $table->string('specialization_category')->nullable()->after('phone');
            $table->string('specialization_subcategory')->nullable()->after('specialization_category');
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
            $table->dropColumn(['specialization_category', 'specialization_subcategory']);
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade')->after('phone');
        });
    }
};
