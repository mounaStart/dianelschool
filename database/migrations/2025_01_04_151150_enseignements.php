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
        Schema::create('enseignements', function (Blueprint $table) {
            $table->id();
            //Info personnel 
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance')->nullable();
            $table->string('sexe')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('lieux_naissance')->nullable();
            $table->string('photo');

            // Info proffesionnel 
            $table->string('proffesion')->nullable();
            $table->string('diplome')->nullable();
            $table->string('salaire')->nullable();
            $table->string('type_contrat')->nullable();  
            $table->date('debut_contrat')->nullable(); 
            $table->date('Fin_contrat')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enseignements');
    }
};
