<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoUrlToFrenchCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('french_companies', function (Blueprint $table) {
            $table->string('logo_url')->nullable()->after('linkedin_url');
        });
    }

    public function down()
    {
        Schema::table('french_companies', function (Blueprint $table) {
            $table->dropColumn('logo_url');
        });
    }
}
