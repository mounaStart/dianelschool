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

        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('classe');
            $table->string('numero_national')->nullable();
            $table->string('sexe')->nullable();
            $table->string('nationalite')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieux_naissance')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('type_eleve')->nullable();  // Passant, Nouveau, Redoublant
            $table->string('moyen_transport')->nullable();  // Public, Privé
            $table->unsignedBigInteger('parent_id')->nullable();  // Lien avec les parents
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
            $table->float('moyenne_generale')->nullable();

            $table->timestamps();
        });

        
        // Schema::create('eleves', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nom');
        //     $table->string('prenom');
        //     $table->date('date_naissance');
        //     $table->string('adresse');
        //     $table->string('telephone');
        //     $table->string('email')->unique()->nullable();
        //     // $table->unsignedBigInteger('classe_id');
        //     // $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
        //     // $table->unsignedBigInteger('cycle_id');
        //     // $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');
        //     $table->unsignedBigInteger('parent_id')->nullable();  // Lien avec les parents
        //     $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
        //     $table->timestamps();
        // });
    }
    

    public function down()
    {
        Schema::dropIfExists('eleves');
    }
};
