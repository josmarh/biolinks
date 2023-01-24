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
        Schema::create('bl_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->bigInteger('custom_id');
            $table->bigInteger('total_links')->default(0);
            $table->bigInteger('total_unique_clicks')->default(0);
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->index(['custom_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_projects');
    }
};
