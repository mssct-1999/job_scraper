<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrenchCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('french_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('sector')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Brazil');
            $table->string('website')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('source_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['country', 'state', 'city']);
            $table->index('sector');
        });
    }

    public function down()
    {
        Schema::dropIfExists('french_companies');
    }
}
