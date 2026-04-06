<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStringIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('category_post', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('flash_infos', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('socials', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('towns', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('string_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('flash_infos', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('socials', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('towns', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('string_id');
        });
    }
}
