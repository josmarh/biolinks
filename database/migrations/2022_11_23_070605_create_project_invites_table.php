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
        Schema::create('bl_project_invites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('invitee_name');
            $table->string('invitee_email');
            $table->string('invite_id', 32);
            $table->smallInteger('status');
            $table->bigInteger('invited_by');
            $table->timestamps();
            $table->index(['project_id', 'invitee_email', 'invite_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bl_project_invites');
    }
};
