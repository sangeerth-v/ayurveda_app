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
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pharma_company_id')->constrained()->onDelete('cascade');

    $table->string('name');
    $table->string('category')->nullable();
    $table->text('description')->nullable();
    $table->decimal('price', 8, 2);
    $table->integer('stock')->default(0);

    $table->string('image')->nullable(); // store image path
    $table->date('expiry_date')->nullable();

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
        Schema::dropIfExists('products');
    }
};
