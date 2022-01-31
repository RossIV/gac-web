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
            $table->addColumn('string', 'motto')->nullable();
            $table->addColumn('boolean', 'accept_additional_members')->nullable();
            $table->addColumn('timestamp', 'terms_agreed_at')->nullable();
            $table->addColumn('unsignedBigInteger', 'terms_agreed_by')->nullable();

            $table->foreign('terms_agreed_by')->references('id')->on('users');
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
            $table->dropColumn('terms_agreed_at');
            $table->dropColumn('terms_agreed_by');
        });
    }
}
