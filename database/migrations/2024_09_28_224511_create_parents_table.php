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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('prenom'); // Prénom du parent
            $table->string('nom'); // Nom de famille du parent
            $table->enum('relation', ['père', 'mère', 'tuteur']); // Relation avec l'élève
            $table->string('telephone')->nullable(); // Numéro de téléphone
            $table->string('email')->unique()->nullable(); // Adresse email
            $table->timestamps(); // Timestamps pour created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('parents');
    }
};
