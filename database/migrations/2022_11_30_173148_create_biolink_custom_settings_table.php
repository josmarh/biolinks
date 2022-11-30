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
        Schema::create('bl_biolink_custom_settings', function (Blueprint $table) {
            $table->id();
            $table->biginteger('link_id');
            $table->text('header_script')->nullable();
            $table->text('footer_script')->nullable();
            $table->timestamps();
            $table->index('link_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_biolink_custom_settings');
    }
};
