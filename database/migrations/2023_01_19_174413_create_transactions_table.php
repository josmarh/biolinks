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
        Schema::create('bl_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('link_id')->nullable();
            $table->bigInteger('section_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('email')->nullable();
            $table->string('order_type')->nullable(); // donation, product, request
            $table->string('fulfilled')->nullable(); // digital
            $table->string('status')->nullable(); // successful
            $table->string('description')->nullable(); // title of sale link
            $table->decimal('amount', $precision = 17, $scale = 2)->default(0);
            $table->string('transaction_type')->nullable(); // Sale, refund
            $table->string('payment_type')->nullable(); // card || paypal
            $table->string('pg_tranx_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();
            $table->index(['link_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_transactions');
    }
};
