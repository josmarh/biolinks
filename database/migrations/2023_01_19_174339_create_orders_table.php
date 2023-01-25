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
        Schema::create('bl_orders', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('order_type')->nullable();
            $table->string('fulfilled')->nullable();
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('product_source')->nullable();
            $table->bigInteger('link_id')->nullable();
            $table->bigInteger('section_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->decimal('total', $precision = 17, $scale = 2)->default(0);
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
        Schema::dropIfExists('bl_orders');
    }
};
