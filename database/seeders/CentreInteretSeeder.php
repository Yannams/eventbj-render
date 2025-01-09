<?php

namespace Database\Seeders;

use App\Models\Centre_interet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentreInteretSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Centre_interet::create(['nom_ci'=>'Musique']);
        Centre_interet::create(['nom_ci'=>'Sport']);
        Centre_interet::create(['nom_ci'=>'Théatre']);
        Centre_interet::create(['nom_ci'=>'Entrepreneuriat et business']);
        Centre_interet::create(['nom_ci'=>'Politique']);
        Centre_interet::create(['nom_ci'=>'Art']);
        Centre_interet::create(['nom_ci'=>'Sciences']);
        Centre_interet::create(['nom_ci'=>'Technologie']);
        Centre_interet::create(['nom_ci'=>'Mode']);
        Centre_interet::create(['nom_ci'=>'Politique']);
        Centre_interet::create(['nom_ci'=>'Spiritualité et réligion']);
        Centre_interet::create(['nom_ci'=>'Culture']);
        Centre_interet::create(['nom_ci'=>'Histoire']);
        Centre_interet::create(['nom_ci'=>'Nourriture']);
        Centre_interet::create(['nom_ci'=>'Gaming']);
        Centre_interet::create(['nom_ci'=>'Education']);
        Centre_interet::create(['nom_ci'=>'Cinéma']);
        Centre_interet::create(['nom_ci'=>'Photographie']);
        Centre_interet::create(['nom_ci'=>'Jeux']);
        Centre_interet::create(['nom_ci'=>'Animaux']);
        Centre_interet::create(['nom_ci'=>'Voyage et découverte']);
        Centre_interet::create(['nom_ci'=>'Danse']);
        Centre_interet::create(['nom_ci'=>'Lecture']);
        Centre_interet::create(['nom_ci'=>'Humour']);
        Centre_interet::create(['nom_ci'=>'Autres']);
    }
}
