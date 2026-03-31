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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telephone_mobile')->nullable();
            $table->string('tva')->nullable();
            $table->string('site_web')->nullable();
            $table->string('langue', 5)->default('fr'); // ex: fr, en
            
            // Rôles avec ENUM
            $table->enum('role', ['ADMIN', 'USER', 'PROVIDER', 'TEMP'])->default('USER');
            
            // Sécurité et État
            $table->integer('nombre_tentatives_connexion')->default(0);
            $table->boolean('est_banni')->default(false);
            $table->boolean('newsletter')->default(false);
            $table->timestamp('email_verified_at')->nullable();
             $table->string('inscription_confirmation_token', 64)->nullable(); //->after('email');
            
            // Clé étrangère pour l'adresse (table adresses à créer au préalable)
            $table->foreignId('adresse_id')->nullable()->constrained('adresses')->onDelete('set null');
            
            $table->timestamps(); // Gère automatiquement 'date inscription' (created_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
