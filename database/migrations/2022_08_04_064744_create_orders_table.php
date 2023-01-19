<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->integer('user_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('product')->nullable();
            $table->string('mark')->nullable();
            $table->string('product_price')->nullable();
            $table->enum('status', ['pending', 'accept', 'decline', 'completed', 'delivered'])->nullable();
            $table->longText('decline_reasone')->nullable();
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
}
