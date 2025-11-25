<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->string('rib')->unique();       // RIB unique
            $table->decimal('solde', 10, 2)->default(0); // Solde décimal avec 2 chiffres après la virgule

            // Foreign key vers clients.id
            $table->foreignId('client_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
