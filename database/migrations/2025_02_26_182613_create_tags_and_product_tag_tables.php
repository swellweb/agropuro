<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsAndProductTagTables extends Migration
{
    public function up()
    {
        // Tabella tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Tabella pivot product_tag
        Schema::create('product_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Modifica products per rimuovere il campo tag
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tag');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('tags');
        Schema::table('products', function (Blueprint $table) {
            $table->json('tag')->nullable();
        });
    }
}
