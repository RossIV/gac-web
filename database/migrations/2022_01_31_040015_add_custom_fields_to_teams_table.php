<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Config::get('teamwork.teams_table'), function (Blueprint $table) {
            $table->string('motto')->nullable();
            $table->boolean('accept_additional_members')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Config::get('teamwork.teams_table'), function (Blueprint $table) {
            $table->dropColumn('motto');
            $table->dropColumn('accept_additional_members');
        });
    }
}
