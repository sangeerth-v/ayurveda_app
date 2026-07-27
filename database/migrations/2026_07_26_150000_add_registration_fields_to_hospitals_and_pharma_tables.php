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
        // Add fields to hospitals table
        Schema::table('hospitals', function (Blueprint $table) {
            if (!Schema::hasColumn('hospitals', 'license_number')) {
                $table->string('license_number')->nullable()->after('name');
            }
            if (!Schema::hasColumn('hospitals', 'gst_number')) {
                $table->string('gst_number')->nullable()->after('license_number');
            }
            if (!Schema::hasColumn('hospitals', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('hospitals', 'license_document')) {
                $table->string('license_document')->nullable()->after('logo');
            }
        });

        // Add fields to pharma_companies table
        Schema::table('pharma_companies', function (Blueprint $table) {
            if (!Schema::hasColumn('pharma_companies', 'drug_license_no')) {
                $table->string('drug_license_no')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('pharma_companies', 'gst_number')) {
                $table->string('gst_number')->nullable()->after('drug_license_no');
            }
            if (!Schema::hasColumn('pharma_companies', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('pharma_companies', 'password_plain')) {
                $table->string('password_plain')->nullable()->after('password');
            }
            if (!Schema::hasColumn('pharma_companies', 'license_document')) {
                $table->string('license_document')->nullable()->after('logo');
            }
            if (!Schema::hasColumn('pharma_companies', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('license_document');
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
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn(['license_number', 'gst_number', 'contact_person', 'license_document']);
        });

        Schema::table('pharma_companies', function (Blueprint $table) {
            $table->dropColumn(['drug_license_no', 'gst_number', 'contact_person', 'password_plain', 'license_document', 'is_active']);
        });
    }
};
