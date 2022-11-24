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
        Schema::create('bl_project_links', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->length(5);
            $table->string('link_id');
            $table->enum('type', ['biolink','link']);
            $table->text('long_url')->nullable();
            $table->bigInteger('total_leads')->default(0);
            $table->bigInteger('total_unique_clicks')->default(0);
            $table->enum('status', ['active','inactive'])->default('active');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->index(['project_id', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_project_links');
    }
};
