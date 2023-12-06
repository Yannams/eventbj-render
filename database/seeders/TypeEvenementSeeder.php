<?php

namespace Database\Seeders;

use App\Models\type_evenement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeEvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_evenement =[
            [
                "nom_type_evenement"=> "Tout",
                "description"=> "Tous les évènements",
            ],
            [
                "nom_type_evenement"=> "Chill",
                "description"=> "évènement festifs ou rassemblement",
            ],
            [
                "nom_type_evenement"=> "festival ou salon",
                "description"=> "évènement de plusieurs jours",
            ],
            [
                "nom_type_evenement"=> "Conférence",
                "description"=> "évènement avec des invité pour parler sur différents pannels",
            ],
            [
                "nom_type_evenement"=> "Evenement sportif ou competition",
                "description"=> "évènement qui est une compétion, un tournoi ou un jeu ",
            ],
            [
                "nom_type_evenement"=> "Concert",
                "description"=> "évènement avec des artistes en prestation",
            ],
            [
                "nom_type_evenement"=> "bal ou gala",
                "description"=> "Soirée chic et glamour ",
            ],
        ];
        type_evenement::insert($type_evenement);
    }
}
