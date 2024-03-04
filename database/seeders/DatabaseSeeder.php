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
            ['name' => 'Assédio Sexual'],
            ['name' => 'Ataque terrorista'],
            ['name' => 'Brigas de rua'],
            ['name' => 'Descarte de lixo irregular'],
            ['name' => 'Estupro'],
            ['name' => 'Extorsão'],
            ['name' => 'Feminicídio'],
            ['name' => 'Fraudes e golpes'],
            ['name' => 'Furto'],
            ['name' => 'Homicídio'],
            ['name' => 'Infanticídio'],
            ['name' => 'Invasão de domicílio'],
            ['name' => 'Pertubaçao do sossego'],
            ['name' => 'Roubo'],
            ['name' => 'Sequestro'],
            ['name' => 'Tráfico de drogas'],
            ['name' => 'Tráfico de pessoas'],
        ]);

        Report::create([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'lat' => '-9.664',
            'lon' => '-35.701',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);

        Report::create([
            'crime_id' => '6',
            'osm_type' => 'W',
            'osm_id' => '1234567891',
            'lat' => '-9.664',
            'lon' => '-35.702',
            'date' => '2024-02-27',
            'time' => '23:45:02'
        ]);

        Report::create([
            'crime_id' => '7',
            'osm_type' => 'R',
            'osm_id' => '1234567892',
            'lat' => '-9.664',
            'lon' => '-35.703',
            'date' => '2024-02-27',
            'time' => '23:45:03'
        ]);

        Report::create([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '1234567893',
            'lat' => '-9.664',
            'lon' => '-35.704',
            'date' => '2024-02-27',
            'time' => '23:45:04'
        ]);

        Report::create([
            'crime_id' => '9',
            'osm_type' => 'W',
            'osm_id' => '1234567894',
            'lat' => '-9.664',
            'lon' => '-35.705',
            'date' => '2024-02-27',
            'time' => '23:45:05'
        ]);

        Report::create([
            'crime_id' => '10',
            'osm_type' => 'R',
            'osm_id' => '1234567895',
            'lat' => '-9.664',
            'lon' => '-35.706',
            'date' => '2024-02-27',
            'time' => '23:45:06'
        ]);
    }
}
