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
        Schema::create('bl_payment_integrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('stripe_status', 8)->default('disabled');
            $table->text('stripe_secret')->nullable();
            $table->string('paypal_status', 8)->default('disabled');
            $table->text('paypal_secret')->nullable();
            $table->text('paypal_client')->nullable();
            $table->timestamps();
            $table->index(['project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_payment_integrations');
    }
};
