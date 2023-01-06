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
        Schema::create('bl_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->bigInteger('link_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('category')->nullable();
            $table->text('images')->nullable();
            $table->text('pricing');
            $table->text('shipping');
            $table->text('inventory');
            $table->text('files');
            $table->string('external_link')->nullable();
            $table->string('published_status', 20)->default('Upublished');
            $table->timestamps();
            $table->index(['project_id','link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_products');
    }
};
