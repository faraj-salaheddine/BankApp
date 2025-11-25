<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();                           // id auto-incrémenté
            $table->string('nom');                  // nom du client
            $table->string('prenom');               // prénom du client
            $table->string('email')->unique();      // email unique
            $table->timestamps();                   // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
