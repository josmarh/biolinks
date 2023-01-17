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
        Schema::create('bl_membership_blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unique();
            $table->string('headline_color', 7);
            $table->string('text_color', 7);
            $table->string('bg_color', 7);
            $table->string('button_color', 7);
            $table->string('link_color', 7);
            $table->string('post_bg_color', 7);
            $table->string('title');
            $table->string('sub_heading');
            $table->string('disclaimer')->nullable();
            $table->string('header_font_family');
            $table->string('text_font_family');
            $table->string('posts');
            $table->string('subsscriber_alert');
            $table->string('subsscriber_alert_color');
            $table->string('emailbox');
            $table->string('post_gated_content');
            $table->text('main_setting');
            $table->text('smedia');
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
        Schema::dropIfExists('bl_membership_blogs');
    }
};
