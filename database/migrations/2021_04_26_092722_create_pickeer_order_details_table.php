<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickeerOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickeer_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('db_order_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->string('err')->nullable();
            $table->string('success');
            $table->string('order_id');
            $table->string('dispatch_mode');
            $table->string('client_order_id');
            $table->string('ip_string')->nullable();
            $table->string('courier');
            $table->string('tracking_id');
            $table->string('manifest_link_pdf');
            $table->string('manifest_img_link_v2')->nullable();
            $table->string('routing_code');
            $table->string('manifest_img_link');
            $table->string('order_pk');
            $table->string('manifest_link');
            $table->boolean('status')->default(1);
            $table->boolean('deleted')->default(0);
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();
            $table->foreign('db_order_id')->references('id')->on('orders');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickeer_order_details');
    }
}
