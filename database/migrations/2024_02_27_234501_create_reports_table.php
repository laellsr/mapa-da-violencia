<?php

use Brick\Math\BigInteger;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $osm_types_enum = ['N', 'W', 'R'];

        Schema::create('reports', function (Blueprint $table) use ($osm_types_enum){
            $table->id();
            $table->foreignId('crime_id')->constrained('crimes');
            $table->enum('osm_type',  $osm_types_enum);
            $table->BigInteger('osm_id');
            $table->string('lat');
            $table->string('lon');
            $table->date('date');
            $table->time('time');
            $table->timestamps();
            // Suburb
            $table->string('suburb');
            $table->enum('suburb_osm_type',  $osm_types_enum);
            $table->BigInteger('suburb_osm_id');
            // City
            $table->string('city');
            $table->enum('city_osm_type',  $osm_types_enum);
            $table->BigInteger('city_osm_id');
            // State
            $table->string('state');
            $table->enum('state_osm_type',  $osm_types_enum);
            $table->BigInteger('state_osm_id');
            // Region
            $table->string('region');
            $table->enum('region_osm_type',  $osm_types_enum);
            $table->BigInteger('region_osm_id');
            // Country
            $table->string('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
