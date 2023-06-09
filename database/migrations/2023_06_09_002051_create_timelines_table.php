<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelinesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('task_id')->on('tasks')->reference('id');
            $table->enum('status', TaskStatus::getValues());
            $table->datetime('date');
            $table->foreignId('updated_by')->on('users')->reference('id');
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
        Schema::drop('timelines');
    }
}
