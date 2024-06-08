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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('startH');
            $table->string('endH');
            $table->unsignedBigInteger("subject_id");
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('restrict');
            $table->unsignedBigInteger("trainingcourse_id");
            $table->foreign('trainingcourse_id')
                ->references('id')
                ->on('training_courses')
                ->onDelete('restrict');
            $table->unsignedBigInteger("sess_id");
            $table->foreign('sess_id')
                ->references('id')
                ->on('sesses')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
