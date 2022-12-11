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
        Schema::create('bl_biolink_sections', function (Blueprint $table) {
            $table->id();
            $table->biginteger('link_id');
            $table->biginteger('section_id');
            $table->string('button_text')->nullable();
            $table->string('button_text_color', 7)->nullable();
            $table->string('button_bg_color', 7)->nullable();
            $table->text('core_section_fields');
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
        Schema::dropIfExists('bl_biolink_sections');
    }
};
