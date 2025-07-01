<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['urgent', 'high', 'normal'])->default('normal');
            $table->date('deadline')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->decimal('priority_score', 8, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'sort_order']);
            $table->index(['deadline', 'status']);
            $table->enum('status', ['draft', 'todo', 'in_progress', 'done'])->default('draft');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};