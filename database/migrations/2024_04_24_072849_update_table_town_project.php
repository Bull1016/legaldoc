<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableTownProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('towns', function (Blueprint $table) {
            $table->bigInteger('vpn_id')->after('country_id');
        });
        
        Schema::table('projects', function (Blueprint $table) {
            $table->bigInteger('categorie_id')->after('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('towns', function (Blueprint $table) {
            $table->dropColumn('vpn_id');
        });
        
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('categorie_id');
        });
    }
}
