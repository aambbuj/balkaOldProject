<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('sku');
            $table->unsignedBigInteger('sku_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('vendor_product_id')->nullable();
            $table->string('product_name',100)->unique();
            $table->text('product_description')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('category_name')->nullable();
            $table->integer('qty_per_unit');
            $table->decimal('unit_price');
            $table->decimal('msrp')->nullable();
            $table->integer('available_size')->nullable();
            $table->integer('available_colors')->nullable();
            $table->text('size')->nullable();
            $table->text('color')->nullable();
            $table->decimal('discount');
            $table->decimal('unit_weight')->nullable();
            $table->integer('units_in_stock')->nullable();
            $table->integer('units_on_order')->nullable();
            $table->integer('reorder_level')->nullable();
            $table->boolean('product_available')->default(1);
            $table->boolean('discount_available')->default(0);
            $table->integer('current_order')->nullable();
            $table->string('image');
            $table->integer('ranking')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('deleted')->default(0);
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands');
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
}
