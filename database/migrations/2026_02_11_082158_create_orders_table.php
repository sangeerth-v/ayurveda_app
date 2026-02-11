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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    $table->string('delivery_name');
    $table->string('delivery_phone');
    $table->string('delivery_district');
    $table->text('delivery_address');

    $table->decimal('total_price', 10, 2);
    $table->string('payment_method')->default('COD');
    $table->string('payment_status')->default('Pending');
    $table->string('order_status')->default('Placed'); // Placed, Shipped, Delivered

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
        Schema::dropIfExists('orders');
    }
};
