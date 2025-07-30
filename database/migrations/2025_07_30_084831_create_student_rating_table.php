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
        Schema::create('student_rating', function (Blueprint $table) {
            $table->id();
            $table->integer('rate')->default(1);
              $table->foreignId('student_id')->references('id')->on("students")->onDelete('cascade')->onUpdate('cascade');
            $table->string('comment');
            $table->morphs('rateable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_rating');
    }
};
