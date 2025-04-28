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
            $table->string('penetapan',length:500);
            $table->string('pelaksanaan',length:500);
            $table->string('evaluasi',length:500);
            $table->string('pengendalian',length:500);
            $table->string('peningkatan',length:500);
            $table->string('pendukung',length:500);
            $table->timestamps();

            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria');
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
