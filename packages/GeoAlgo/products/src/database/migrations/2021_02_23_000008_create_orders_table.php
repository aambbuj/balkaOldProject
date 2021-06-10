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
            $table->unsignedBigInteger('customer_id')->nullable();
            //$table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('order_number',50);
            $table->dateTime('order_date');
            $table->integer('vcode')->nullable();
            $table->dateTime('ship_date')->nullable();
            $table->dateTime('required_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->decimal('total_amount');
            $table->decimal('sell_tex')->nullable();
            $table->boolean('transact_status');
            $table->boolean('status')->default(1);
            $table->boolean('deleted')->default(0);
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();
        //     $table->foreign('customer_id')->references('id')->on('customers');
        //    // $table->foreign('company_id')->references('id')->on('companies');
        //     $table->foreign('payment_id')->references('id')->on('payments');
        //     $table->foreign('shipper_id')->references('id')->on('shippers');
        //     $table->foreign('user_id')->references('id')->on('users');

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
