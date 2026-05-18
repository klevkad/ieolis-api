<?php

namespace Database\Seeders;

use App\Models\Old\Parc\Chargeur;
use App\Models\Old\Parc\Prise;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
/*
        for($i=35; $i<43; $i++) {
            Chargeur::create([
                'libelle' => 'CHAB'.( $i<9 ? '00'.($i+1) : '0'.($i+1) )
            ]);
        }

        for($i=65; $i<81; $i++) {
            Prise::create([
                'libelle' => 'PRIB'.( $i<9 ? '00'.($i+1) : '0'.($i+1) ),
                'created_by' => 2
            ]);
        }
*/
    }
}
