<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZipCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zip', 5)->index('zip');
            $table->float('lat');
            $table->float('lng');
            $table->string('city', 50)->index('city');
            $table->string('state_id', 2);
            $table->string('state_name', 50);
            $table->boolean('zcta');
            $table->string('parent_zcta', 50);
            $table->bigInteger('population')->default(0);
            $table->float('density');
            $table->string('county_fips', 5);
            $table->string('county_fips_all', 50);
            $table->string('county_name', 50);
            $table->string('county_names_all', 255);
            $table->string('county_weights', 255);
            $table->boolean('imprecise');
            $table->boolean('military');
            $table->string('timezone', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zips');
    }
}
