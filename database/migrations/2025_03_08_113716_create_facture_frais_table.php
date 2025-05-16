<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureFraisTable extends Migration
{
    public function up()
    {
        Schema::create('facture_frais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained()->onDelete('cascade')->unsigned(); // Ajoutez ->unsigned()
            $table->foreignId('frais_scolaires_id')->constrained()->onDelete('cascade')->unsigned(); // Ajoutez ->unsigned()
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('facture_frais');
    }
}
