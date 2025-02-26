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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('farmer_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->text('descrizione')->nullable();
        $table->string('tipo');
        $table->decimal('prezzo', 8, 2)->nullable();
        $table->integer('quantita_disponibile')->default(0);
        $table->string('unita_misura')->default('kg');
        $table->string('immagine')->nullable();
        $table->string('video')->nullable();
        $table->json('galleria')->nullable();
        $table->json('tag')->nullable();
        $table->string('stagionalita')->nullable();
        $table->string('certificazioni')->nullable();
        $table->timestamps();
    });

    Schema::table('farmers', function (Blueprint $table) {
        $table->dropColumn('product');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
