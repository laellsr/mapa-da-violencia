<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Crime;
use App\Models\Report;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Crime::insert([
            ['name' => 'Assédio Sexual', 'heatmap_intensity' => 0.4],
            ['name' => 'Ataque terrorista', 'heatmap_intensity' => 1],
            ['name' => 'Brigas de rua', 'heatmap_intensity' => 0.4],
            ['name' => 'Descarte de lixo irregular', 'heatmap_intensity' => 0.4],
            ['name' => 'Estupro', 'heatmap_intensity' => 0.8],
            ['name' => 'Extorsão', 'heatmap_intensity' => 0.4],
            ['name' => 'Feminicídio', 'heatmap_intensity' => 1],
            ['name' => 'Fraudes e golpes', 'heatmap_intensity' => 0.7],
            ['name' => 'Furto', 'heatmap_intensity' => 0.4],
            ['name' => 'Homicídio', 'heatmap_intensity' => 1],
            ['name' => 'Infanticídio', 'heatmap_intensity' => 1],
            ['name' => 'Invasão de domicílio', 'heatmap_intensity' => 0.8],
            ['name' => 'Pertubaçao do sossego', 'heatmap_intensity' => 0.4],
            ['name' => 'Roubo', 'heatmap_intensity' => 0.7],
            ['name' => 'Sequestro', 'heatmap_intensity' => 0.8],
            ['name' => 'Tráfico de drogas', 'heatmap_intensity' => 0.6],
            ['name' => 'Tráfico de pessoas', 'heatmap_intensity' => 1],
        ]);

        //IPIOCA
        Report::create([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.524677', 
            'lon' => '-35.606986',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '7',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.526024', 
            'lon' => '-35.609512',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //PESCARIA
        Report::create([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.538612', 
            'lon' => '-35.621694',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '13',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.537610', 
            'lon' => '-35.619965',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //RIACHO DOCE
        Report::create([
            'crime_id' => '2',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.576342', 
            'lon' => '-35.660680',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '9',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.574091', 
            'lon' => '-35.658172',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //GARÇA TORTA
        Report::create([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.582046', 
            'lon' => '-35.666848',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '4',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.579379', 
            'lon' => '-35.663215',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //GUAXUMA
        Report::create([
            'crime_id' => '6',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.595075', 
            'lon' => '-35.678017',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '11',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.593832',  
            'lon' => '-35.681753',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //JACARECICA
        Report::create([
            'crime_id' => '3',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.582539', 
            'lon' => '-35.705192',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '15',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.580547',  
            'lon' => '-35.701259',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //CRUZ DAS ALMAS
        Report::create([
            'crime_id' => '10',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.627310',
            'lon' => '-35.707687',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.625374', 
            'lon' => '-35.707848',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //BENEDITO BENTES
        Report::create([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.539858',
            'lon' => '-35.721529',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '1',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.567206', 
            'lon' => '-35.718163',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //ANTARES
        Report::create([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.583499', 
            'lon' => '-35.731653',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '10',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.567230', 
            'lon' => '-35.746485',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //CIDADE UNIVERSITARIA
        Report::create([
            'crime_id' => '1',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.553442', 
            'lon' => '-35.776745',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.531442', 
            'lon' => '-35.774363',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        //POÇO
        Report::create([
            'crime_id' => '3',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.662112', 
            'lon' => '-35.723071',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);
        Report::create([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.656882', 
            'lon' => '-35.715096',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);

    }
}
