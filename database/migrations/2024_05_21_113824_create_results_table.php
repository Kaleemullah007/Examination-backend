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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('correct_answer');
            $table->integer('wrong_answer');
            $table->integer('user_attempts')->default(1);
            $table->unsignedBigInteger('paper_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('user_id');
            $table->char('status')->default('pending');
            $table->boolean('is_locked')->default(false);
            

            $table->foreign('paper_id')->references('id')->on('papers');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
