<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPriorityScoreFromTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('priority_score');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('priority_score')->default(0)->after('some_column');
        });
    }
}
