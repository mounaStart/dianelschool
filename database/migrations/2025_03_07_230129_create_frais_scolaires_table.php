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
        Schema::create('frais_scolaires', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Ex : Inscription, Mensualité, etc.
            $table->decimal('montant', 10, 2); // Ex : 5000.00
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais_scolaires');
    }
};
