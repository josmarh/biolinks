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
        Schema::create('bl_plans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('title');
            $table->string('description');
            $table->string('unlock_type');
            $table->string('monthly_pricing')->length(5);
            $table->decimal('monthly_price', $precision = 17, $scale = 2)->nullable();
            $table->string('annual_pricing')->length(5);
            $table->decimal('annual_price', $precision = 17, $scale = 2)->nullable();
            $table->text('action');
            $table->timestamps();
            $table->index(['project_id']);
        });
    }
    // create table bl_plans (
    //     id bigint unsigned NOT NULL AUTO_INCREMENT,
    //     project_id bigint,
    //     title varchar(255) default null,
    //     description varchar(255) default null,
    //     unlock_type varchar(255) default null,
    //     monthly_pricing varchar(5) default null,
    //     monthly_price decimal(17, 2) default 0,
    //     annual_pricing varchar(5) default null,
    //     annual_price decimal(17, 2) default 0,
    //     action text default null,
    //     created_at timestamp NULL DEFAULT NULL,
    //     updated_at timestamp NULL DEFAULT NULL,
    //     PRIMARY KEY (`id`),
    //     KEY `bl_posts_project_id_index` (`project_id`)
    // );
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_plans');
    }
};
