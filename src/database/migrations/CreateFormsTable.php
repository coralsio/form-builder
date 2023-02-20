<?php

namespace Corals\Modules\FormBuilder\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('short_code')->unique();
            $table->longText('content');
            $table->text('properties')->nullable();
            $table->longText('actions')->nullable();
            $table->text('submission')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_public')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->increments('id');

            $table->longText('content');
            $table->string('unique_identifier')->nullable();
            $table->unsignedInteger('form_id');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('forms');
    }
}
