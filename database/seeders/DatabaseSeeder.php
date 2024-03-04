<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        Report::create([
            'crime_id' => '5',
            'osm_type' => 'N',
            'osm_id' => '1234567890',
            'location' => 'POINT(-9.664 -35.701)',
            'date' => '2024-02-27',
            'time' => '23:45:01'
        ]);

        Report::create([
            'crime_id' => '6',
            'osm_type' => 'W',
            'osm_id' => '1234567891',
            'location' => 'POINT(-9.664 -35.702)',
            'date' => '2024-02-27',
            'time' => '23:45:02'
        ]);

        Report::create([
            'crime_id' => '7',
            'osm_type' => 'R',
            'osm_id' => '1234567892',
            'location' => 'POINT(-9.664 -35.703)',
            'date' => '2024-02-27',
            'time' => '23:45:03'
        ]);

        Report::create([
            'crime_id' => '8',
            'osm_type' => 'N',
            'osm_id' => '1234567893',
            'location' => 'POINT(-9.664 -35.704)',
            'date' => '2024-02-27',
            'time' => '23:45:04'
        ]);

        Report::create([
            'crime_id' => '9',
            'osm_type' => 'W',
            'osm_id' => '1234567894',
            'location' => 'POINT(-9.664 -35.705)',
            'date' => '2024-02-27',
            'time' => '23:45:05'
        ]);

        Report::create([
            'crime_id' => '10',
            'osm_type' => 'R',
            'osm_id' => '1234567895',
            'location' => 'POINT(-9.664 -35.706)',
            'date' => '2024-02-27',
            'time' => '23:45:06'
        ]);

        Crime::create([
            'name' => 'Assédio Sexual',
        ]);

        Crime::create([
            'name' => 'Ataque terrorista',
        ]);

        Crime::create([
            'name' => 'Brigas de rua',
        ]);

        Crime::create([
            'name' => 'Descarte de lixo irregular',
        ]);

        Crime::create([
            'name' => 'Estupro',
        ]);

        Crime::create([
            'name' => 'Extorsão',
        ]);

        Crime::create([
            'name' => 'Feminicídio',
        ]);

        Crime::create([
            'name' => 'Fraudes e golpes',
        ]);

        Crime::create([
            'name' => 'Furto',
        ]);

        Crime::create([
            'name' => 'Homicídio',
        ]);

        Crime::create([
            'name' => 'Infanticídio',
        ]);

        Crime::create([
            'name' => 'Invasão de domicílio',
        ]);

        Crime::create([
            'name' => 'Pertubaçao do sossego',
        ]);

        Crime::create([
            'name' => 'Roubo',
        ]);

        Crime::create([
            'name' => 'Sequestro',
        ]);

        Crime::create([
            'name' => 'Tráfico de drogas',
        ]);

        Crime::create([
            'name' => 'Tráfico de pessoas',
        ]);
    }
}
