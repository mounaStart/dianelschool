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
        // Schema::create('notes', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade'); // Clé étrangère vers la table eleves
        //     $table->string('matiere'); // Matière
        //     $table->float('note'); // Note
        //     $table->enum('term', ['premier', 'deuxième', 'final']); // Terme de l'année scolaire
        //     $table->timestamps(); // Timestamps pour created_at et updated_at
        // });
    }

    public function down()
    {
        // Schema::dropIfExists('notes');
    }
};
