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
        Schema::create('bl_visitors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('link_id');
            $table->bigInteger('section_id');
            $table->string('ip', 50)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('country_flag', 255)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('os', 50)->nullable();
            $table->timestamps();
            $table->index(['link_id','section_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_visitors');
    }
};
