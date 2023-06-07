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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('team_member_id')->references('id')->on('team_members');
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id','team_member_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_members');
    }
};
