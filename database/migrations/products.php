<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->bigInteger('seller_id')->unsigned();
            $table->integer('stock');
            $table->string('image_url')->nullable();
            $table->binary('image_file')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();
    
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
