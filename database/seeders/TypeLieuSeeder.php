<?php

namespace Database\Seeders;

use App\Models\type_lieu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeLieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_lieu =[
            [
                "nom_type"=> "En ligne",
                "description"=> "évènement qui se déroule sur une plateforme en ligne",
            ],
            [
                "nom_type"=> "physique",
                "description"=> "évènement qui se déroule sur un lieu physique",
            ],
        ];
        type_lieu::insert($type_lieu);

    }
}
