<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrazilJobOffersTable extends Migration
{
    public function up()
    {
        Schema::create('brazil_job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('french_company_id')->nullable()->constrained('french_companies')->nullOnDelete();
            $table->string('title');
            $table->string('offer_type')->default('VIE');
            $table->string('status')->default('open');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Brazil');
            $table->string('source')->default('manual');
            $table->string('source_url')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('scraped_at')->nullable();
            $table->longText('description')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();

            $table->index(['offer_type', 'status']);
            $table->index(['country', 'state', 'city']);
            $table->index('source');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brazil_job_offers');
    }
}
