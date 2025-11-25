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
    Schema::table('comptes', function (Blueprint $table) {
        $table->string('type_compte')->default('courant'); // simple, courant, epargne
        $table->string('statut')->default('actif');        // actif, suspendu, fermé
    });
}

public function down()
{
    Schema::table('comptes', function (Blueprint $table) {
        $table->dropColumn(['type_compte', 'statut']);
    });
}

};
