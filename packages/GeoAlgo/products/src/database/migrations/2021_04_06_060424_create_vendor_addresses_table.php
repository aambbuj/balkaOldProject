<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type_establishment',100)->nullable();
            $table->string('reg_address')->nullable();
            $table->string('shi_address')->nullable();
            $table->string('authorised_person')->nullable();
           $table->string('authorised_contact')->nullable();
           $table->string('authorised_email')->nullable();
           $table->string('product_category')->nullable();
           $table->string('commercial_terms')->nullable();
           $table->string('gst')->nullable();
           $table->string('HSN_codes')->nullable();
           $table->string('shipping_type')->nullable();
           $table->string('vendor_logo')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('deleted')->default(0);
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_addresses');
    }
}
