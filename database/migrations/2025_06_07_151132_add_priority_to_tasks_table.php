<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('tasks', 'priority')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->enum('priority', ['urgent', 'high', 'normal'])->default('normal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('tasks', 'priority')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('priority');
            });
        }
    }
};
