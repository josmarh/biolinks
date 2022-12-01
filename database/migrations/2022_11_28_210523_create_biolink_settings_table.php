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
        Schema::create('bl_biolink_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('link_id');
            $table->string('top_logo')->nullable();
            $table->text('video')->nullable();
            $table->string('title')->nullable();
            $table->string('text_color', 10)->nullable();
            $table->enum('verified_checkmark', ['yes','no']);
            $table->text('description')->nullable();
            $table->string('background_type', 10);
            $table->text('background_type_content');
            $table->text('branding')->nullable();
            $table->text('analytics')->nullable();
            $table->text('seo')->nullable();
            $table->text('utm')->nullable();
            $table->text('socials')->nullable();
            $table->string('font', 15);
            $table->text('section')->nullable();
            $table->text('custom')->nullable();
            $table->timestamps();
            $table->index(['link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_biolink_settings');
    }
};
