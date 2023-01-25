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
        Schema::create('bl_customer_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('card_number')->nullable();
            $table->string('card_month')->nullable();
            $table->string('card_year')->nullable();
            $table->string('card_cvv')->nullable();
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
        Schema::dropIfExists('customer_payment_methods');
    }
};
