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
    Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->string('titre'); // Exemple : "Examen de Mathématiques"
        $table->date('date');
        $table->foreignId('classe_id')->constrained()->onDelete('cascade');
        $table->foreignId('matier_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
