<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('nameOr')->unique();
            $table->text('descriptionOr');
            $table->string('mailOr')->unique();
            $table->string('numberOr');
            $table->string('stateOr');
            
            $table->bigInteger('user_id');
            
            $table->bigInteger('country_id');
            
            $table->bigInteger('town_id');
            
            $table->bigInteger('social_id')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisations');
    }
}
