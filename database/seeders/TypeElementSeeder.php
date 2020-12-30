<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\TypeElement;
use Illuminate\Database\Seeder;

class TypeElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew('Site');
        $this->createNew('BTS');
        $this->createNew('Transmission');
        $this->createNew('Environnement');
        $this->createNew('Securite');
    }

    private function createNew($nom) {
        TypeElement::create(['nom' => $nom,'status_id' => Status::default()->first()->id]);
    }
}
