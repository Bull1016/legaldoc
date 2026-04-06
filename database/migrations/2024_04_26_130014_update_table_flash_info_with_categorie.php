<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableFlashInfoWithCategorie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flash_infos', function (Blueprint $table) {
            $table->bigInteger('categorie_id')->after('file')->unique();
        });
        
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('private')->after('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flash_infos', function (Blueprint $table) {
            $table->dropColumn('categorie_id');
        });
        
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('private');
        });
    }
}
