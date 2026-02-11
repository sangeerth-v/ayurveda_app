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
       Schema::create('doctors', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('phone')->nullable();
    $table->foreignId('department_id')->constrained()->onDelete('cascade');
    $table->foreignId('district_id')->constrained()->onDelete('cascade');

    $table->string('qualification')->nullable();
    $table->integer('experience')->nullable();
    $table->decimal('consultation_fee', 8, 2)->default(0);
    $table->string('available_time')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
