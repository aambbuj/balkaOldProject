<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_settings', function (Blueprint $table) {
            $table->id();
            $table->string("timeline")->nullable();
            $table->string("size_guide")->nullable();
            $table->text("about_the_vendor")->nullable();
            $table->string("featured_product")->nullable();
            $table->string("shipping_type")->nullable();
            $table->string("vendor_payment")->nullable();
            $table->string("logo")->nullable();
            $table->unsignedBigInteger("vendor_id");
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
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
        Schema::dropIfExists('vendor_settings');
    }
}
