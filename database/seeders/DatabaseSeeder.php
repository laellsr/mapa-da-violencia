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

        $ext = [
            "city" => "Maceió",
            "city_osm_type" => "R",
            "city_osm_id" => 303815,
            "state" => "Alagoas",
            "state_osm_type" => "R",
            "state_osm_id" => 303781,
            "region" => "Região Nordeste",
            "region_osm_type" => "R",
            "region_osm_id" => 3360429,
            "country" => "Brasil"
        ];
        //IPIOCA
        $ipioca = [
            "suburb" => "Ipioca",
            "suburb_osm_id" => 5543428,
            "suburb_osm_type" => "R"
        ];

        Report::create(array_merge([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '5543428',
            'lat' => '-9.524677', 
            'lon' => '-35.606986',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $ipioca, $ext));
        Report::create(array_merge([
            'crime_id' => '7',
            'osm_type' => 'N',
            'osm_id' => '5543428',
            'lat' => '-9.526024', 
            'lon' => '-35.609512',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $ipioca, $ext));
        //PESCARIA
        $pescaria = [
            "suburb" => "Pescaria",
            "suburb_osm_id" => 5543420,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '5543420',
            'lat' => '-9.538612', 
            'lon' => '-35.621694',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $pescaria, $ext));
        Report::create(array_merge([
            'crime_id' => '13',
            'osm_type' => 'N',
            'osm_id' => '5543420',
            'lat' => '-9.537610', 
            'lon' => '-35.619965',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $pescaria, $ext));
        //RIACHO DOCE
        $riachodoce = [
            "suburb" => "Riacho Doce",
            "suburb_osm_id" => 5543411,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '2',
            'osm_type' => 'N',
            'osm_id' => '5543411',
            'lat' => '-9.576342', 
            'lon' => '-35.660680',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $riachodoce, $ext));
        Report::create(array_merge([
            'crime_id' => '9',
            'osm_type' => 'N',
            'osm_id' => '5543411',
            'lat' => '-9.574091', 
            'lon' => '-35.658172',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $riachodoce, $ext));
        //GARÇA TORTA
        $garcatorta = [
            "suburb" => "Garca Torta",
            "suburb_osm_id" => 402875,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '402875',
            'lat' => '-9.582046', 
            'lon' => '-35.666848',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $garcatorta, $ext));
        Report::create(array_merge([
            'crime_id' => '4',
            'osm_type' => 'N',
            'osm_id' => '402875',
            'lat' => '-9.579379', 
            'lon' => '-35.663215',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $garcatorta, $ext));
        //GUAXUMA
        $guaxuma = [
            "suburb" => "Guaxuma",
            "suburb_osm_id" => 402314,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '6',
            'osm_type' => 'N',
            'osm_id' => '402314',
            'lat' => '-9.595075', 
            'lon' => '-35.678017',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $guaxuma, $ext));
        Report::create(array_merge([
            'crime_id' => '11',
            'osm_type' => 'N',
            'osm_id' => '402314',
            'lat' => '-9.593832',  
            'lon' => '-35.681753',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $guaxuma, $ext));
        //JACARECICA
        $jacarecica = [
            "suburb" => "Jacarecica",
            "suburb_osm_id" => 402032,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '3',
            'osm_type' => 'N',
            'osm_id' => '402032',
            'lat' => '-9.582539', 
            'lon' => '-35.705192',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $jacarecica, $ext));
        Report::create(array_merge([
            'crime_id' => '15',
            'osm_type' => 'N',
            'osm_id' => '402032',
            'lat' => '-9.580547',  
            'lon' => '-35.701259',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $jacarecica, $ext));
        //CRUZ DAS ALMAS
        $cruzdasalmas = [
            "suburb" => "Cruz das Almas",
            "suburb_osm_id" => 401801,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '10',
            'osm_type' => 'N',
            'osm_id' => '401801',
            'lat' => '-9.627310',
            'lon' => '-35.707687',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $cruzdasalmas, $ext));
        Report::create(array_merge([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '401801',
            'lat' => '-9.625374', 
            'lon' => '-35.707848',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $cruzdasalmas, $ext));
        //BENEDITO BENTES
        $beneditobentes = [
            "suburb" => "Benedito Bentes",
            "suburb_osm_id" => 402896,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '17',
            'osm_type' => 'N',
            'osm_id' => '402896',
            'lat' => '-9.539858',
            'lon' => '-35.721529',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $beneditobentes, $ext));
        Report::create(array_merge([
            'crime_id' => '1',
            'osm_type' => 'N',
            'osm_id' => '402896',
            'lat' => '-9.567206', 
            'lon' => '-35.718163',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $beneditobentes, $ext));
        //ANTARES
        $antares = [
            "suburb" => "Antares",
            "suburb_osm_id" => 402205,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '402205',
            'lat' => '-9.583499', 
            'lon' => '-35.731653',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $antares, $ext));
        Report::create(array_merge([
            'crime_id' => '10',
            'osm_type' => 'N',
            'osm_id' => '402205',
            'lat' => '-9.567230', 
            'lon' => '-35.746485',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $antares, $ext));
        //CIDADE UNIVERSITARIA
        $cidadeuniversitaria = [
            "suburb" => "Cidade Universitaria",
            "suburb_osm_id" => 402830,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '1',
            'osm_type' => 'N',
            'osm_id' => '402830',
            'lat' => '-9.553442', 
            'lon' => '-35.776745',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $cidadeuniversitaria, $ext));
        Report::create(array_merge([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '402830',
            'lat' => '-9.531442', 
            'lon' => '-35.774363',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $cidadeuniversitaria, $ext));
        //POÇO
        $poco = [
            "suburb" => "Poco",
            "suburb_osm_id" => 400191,
            "suburb_osm_type" => "R"
        ];
        Report::create(array_merge([
            'crime_id' => '3',
            'osm_type' => 'N',
            'osm_id' => '400191',
            'lat' => '-9.662112', 
            'lon' => '-35.723071',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $poco, $ext));
        Report::create(array_merge([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '400191',
            'lat' => '-9.656882', 
            'lon' => '-35.715096',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ], $poco, $ext));

    }
}
