<?php

namespace Database\Seeders;

use App\Models\Affiliation;
use Illuminate\Database\Seeder;

class AffiliationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliations = [
            'No GT Band Affiliation',
            'GT Band Alum',
            'Vet (Returning GT Band Student)',
            'R.A.T. (First-Year GT Band Student)'
        ];

        foreach ($affiliations as $affiliation) {
            Affiliation::create(['name' => $affiliation]);
        }
    }
}
