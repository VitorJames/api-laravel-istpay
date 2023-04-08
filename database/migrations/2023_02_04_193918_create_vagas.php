<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVagas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->text('description');
            $table->text('requirements');
            $table->decimal('salary', 8, 2);
            $table->enum('type', [
                'remote',
                'in_person',
                'hybrid',
            ]);
            $table->enum('modality', [
                'clt',
                'pj',
                'freelancer',
            ]);
            $table->enum('status', [
                'active',
                'paused',
                'closed',
            ])->default('active');
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
        Schema::dropIfExists('vagas');
    }
}
