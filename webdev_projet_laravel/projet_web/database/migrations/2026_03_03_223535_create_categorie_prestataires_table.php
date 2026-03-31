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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('categorie_prestataires', function (Blueprint $table) {
           
        $table->foreignId('prestataire_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();

            // Définition de la clé primaire composite (évite les doublons)
            $table->primary(['prestataire_id', 'categorie_id']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_prestataires');
    }
};
