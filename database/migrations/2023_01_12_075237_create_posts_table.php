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
        Schema::create('bl_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('slug')->nullable();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('post')->nullable();
            $table->text('images')->nullable();
            $table->string('featured_image_style');
            $table->text('media')->nullable();
            $table->text('products')->nullable();
            $table->text('courses')->nullable();
            $table->string('published_date')->nullable();
            $table->bigInteger('author')->nullable();
            $table->text('categories')->nullable();
            $table->string('payment_setting');
            $table->decimal('otp', [17, 2])->nullable();
            $table->string('content_preview', 20)->default('no_preview');
            $table->text('plans')->nullable();
            $table->string('published_status', 20)->nullable();
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
        Schema::dropIfExists('bl_posts');
    }
};
