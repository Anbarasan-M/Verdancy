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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ['credit_card', 'cash']);
            $table->enum('status', ['completed', 'failed'])->default('completed');
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
