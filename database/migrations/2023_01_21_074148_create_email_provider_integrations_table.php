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
        Schema::create('bl_email_provider_integrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->text('mailchimp')->nullable();
            $table->text('getresponse')->nullable();
            $table->text('emailoctopus')->nullable();
            $table->text('converterkit')->nullable();
            $table->text('mailerlite')->nullable();
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
        Schema::dropIfExists('bl_email_provider_integrations');
    }
};
