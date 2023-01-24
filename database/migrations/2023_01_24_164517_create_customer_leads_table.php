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
        Schema::create('bl_customer_leads', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('orders')->default(0);
            $table->decimal('lifetime_value', $precision = 17, $scale = 2)->default(0);
            $table->bigInteger('project_id');
            $table->timestamps();
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_customer_leads');
    }
};
