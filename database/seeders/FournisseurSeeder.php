<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\DB;

class FournisseurSeeder extends Seeder
{

    private $fournisseurs = [
        [
            'name' => 'Fournisseur 1',
            'email' => 'fournisseur1@gmail.com',
            'phone' => '123499989',
        ],
        [
            'name' => 'Fournisseur 2',
            'email' => 'fournisseur2@gmail.com',
            'phone' => '133356789',
        ],
        [
            'name' => 'Fournisseur 3',
            'email' => 'fournisseur3@gmail.com',
            'phone' => '123456789',
        ],
        [
            'name' => 'Fournisseur 4',
            'email' => 'fournisseur4@gmail.com',
            'phone' => '127756789',
        ],
        [
            'name' => 'Fournisseur 5',
            'email' => 'fournisseur5@gmail.com',
            'phone' => '111456789',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fournisseurs')->delete();
        DB::statement('ALTER TABLE fournisseurs AUTO_INCREMENT = 1');
        foreach ($this->fournisseurs as $fournisseur) {
            Fournisseur::create($fournisseur);
        }
    }
}
