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
            $table->integer('section_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('admin_type')->nullable();
            $table->longText('product_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->float('product_price')->nullable();
            $table->float('product_old_price')->nullable();
            $table->float('product_discount')->nullable();
            $table->string('product_weight')->nullable();
            $table->longText('product_image')->nullable();
            $table->longText('product_video')->nullable();
            $table->longText('product_short_description')->nullable();
            $table->longText('product_long_description')->nullable();
            $table->longText('product_url');
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('schema')->nullable();
            $table->enum('is_featured', ['No', 'Yes'])->nullable();
            $table->tinyInteger('status');
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
