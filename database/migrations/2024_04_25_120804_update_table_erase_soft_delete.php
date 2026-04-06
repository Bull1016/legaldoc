<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableEraseSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('towns', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('socials', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('exercices', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('flash_infos', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
