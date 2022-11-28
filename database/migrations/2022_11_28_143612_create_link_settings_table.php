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
        Schema::create('bl_link_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('link_id');
            $table->enum('tempurl_schedule', ['yes','no'])->default('no');
            $table->string('tempurl_start_date')->nullable();
            $table->string('tempurl_end_date')->nullable();
            $table->bigInteger('tempurl_click_limit')->nullable();
            $table->text('tempurl_expire_url')->nullable();
            $table->string('protection_password')->nullable();
            $table->enum('protection_consent_warning', ['yes','no'])->default('no');
            $table->string('target_type')->nullable();
            $table->text('target_country', 2)->nullable();
            $table->text('target_device', 8)->nullable();
            $table->text('target_browser_lang', 5)->nullable();
            $table->text('target_os', 10)->nullable();
            $table->timestamps();
            $table->index(['link_id', 'target_country', 'target_browser_lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_link_settings');
    }
};
