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
        Schema::create('detail_kriteria', function (Blueprint $table) {
            $table->id('id_detail_kriteria');
            $table->unsignedBigInteger('id_kriteria')->index();
            $table->unsignedBigInteger('id_penetapan')->index();
            $table->unsignedBigInteger('id_pelaksanaan')->index();
            $table->unsignedBigInteger('id_evaluasi')->index();
            $table->unsignedBigInteger('id_pengendalian')->index();
            $table->unsignedBigInteger('id_peningkatan')->index();
            $table->unsignedBigInteger('id_komentar')->index()->nullable();
            $table->unsignedBigInteger('id_pengisian')->index(); 
            $table->enum('status', ['submitted', 'save', 'revisi', 'acc1', 'acc2']);
            $table->timestamps();

            // Defining foreign keys
            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
            $table->foreign('id_penetapan')->references('id_penetapan')->on('penetapan')->onDelete('cascade');
            $table->foreign('id_pelaksanaan')->references('id_pelaksanaan')->on('pelaksanaan')->onDelete('cascade');
            $table->foreign('id_evaluasi')->references('id_evaluasi')->on('evaluasi')->onDelete('cascade');
            $table->foreign('id_pengendalian')->references('id_pengendalian')->on('pengendalian')->onDelete('cascade');
            $table->foreign('id_peningkatan')->references('id_peningkatan')->on('peningkatan')->onDelete('cascade');
            $table->foreign('id_komentar')->references('id_komentar')->on('komentar')->onDelete('set null');
            $table->foreign('id_pengisian')->references('id_pengisian')->on('pengisian')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kriteria');
    }
};
