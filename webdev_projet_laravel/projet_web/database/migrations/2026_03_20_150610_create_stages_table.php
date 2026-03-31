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
        
        // Dates du stage
        $table->date('date_debut');
        $table->date('date_fin');
        
        // Dates de parution (visibilité sur le site)
        $table->date('date_parution_debut')->nullable();
        $table->date('date_parution_fin')->nullable();
        
        $table->decimal('tarif', 8, 2); // ex: 150.00
        $table->text('info_complementaire')->nullable();

        // Clé étrangère vers le prestataire (table users)
        $table->foreignId('prestataire_id')->constrained('users')->onDelete('cascade');
        
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
