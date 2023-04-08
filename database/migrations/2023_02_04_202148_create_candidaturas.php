<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidaturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidato_id')->nullable();
            $table->unsignedBigInteger('vaga_id')->nullable();
            $table->foreign('candidato_id')
                ->references('id')
                ->on('candidatos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('vaga_id')
                ->references('id')
                ->on('vagas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('candidaturas');
    }
}
