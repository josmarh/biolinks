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
        Schema::create('bl_biolink_section_settings', function (Blueprint $table) {
            $table->id();
            $table->biginteger('link_id');
            $table->string('section_name');
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
        Schema::dropIfExists('bl_biolink_section_settings');
    }
};
