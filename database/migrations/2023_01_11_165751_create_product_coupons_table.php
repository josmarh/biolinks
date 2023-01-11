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
        Schema::create('bl_product_coupons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('coupon_code')->nullable();
            $table->text('apply_to');
            $table->text('discount');
            $table->string('coupon_limit_type');
            $table->bigInteger('coupon_limited_count')->nullable();
            $table->string('limit_per_customer');
            $table->string('is_expires');
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('bl_product_coupons');
    }
};
