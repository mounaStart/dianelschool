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
        Schema::create('eleve_parent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade'); // Clé étrangère vers la table eleves
            $table->foreignId('parent_id')->constrained('parents')->onDelete('cascade'); // Clé étrangère vers la table parents
            $table->timestamps(); // Timestamps pour created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('eleve_parent');
    }
};
