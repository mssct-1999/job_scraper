<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScriptRunsTable extends Migration
{
    public function up()
    {
        Schema::create('script_runs', function (Blueprint $table) {
            $table->id();
            $table->string('script_key');
            $table->string('script_name');
            $table->string('status')->default('pending');
            $table->unsignedInteger('exit_code')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->json('summary')->nullable();
            $table->longText('output')->nullable();
            $table->longText('error_output')->nullable();
            $table->timestamps();

            $table->index(['script_key', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('script_runs');
    }
}
