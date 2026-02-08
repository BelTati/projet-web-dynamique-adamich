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
            Schema::create('stages', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('nom');
            $table->text('description');
            
            // Dates de l'événement
            $table->date('date_debut');
            $table->date('date_fin');
            
            // Dates de visibilité sur le site
            $table->date('date_parution_debut');
            $table->date('date_parution_fin');
            
            $table->decimal('tarif', 8, 2);
            $table->text('info_complementaire')->nullable();
            
            // Clé étrangère vers la table users (le prestataire)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
   
   
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
