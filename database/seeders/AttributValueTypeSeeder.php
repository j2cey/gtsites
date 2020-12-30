<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use App\Models\AttributValueType;

class AttributValueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew('Chaine de caractères', 'string_value');
        $this->createNew('Nombre (grande valeur)', 'biginteger_value');
        $this->createNew('Nombre', 'integer_value');
        $this->createNew('Valeur Binaire', 'binary_value');
        $this->createNew('Valeur Boléenne', 'boolean_value');
        $this->createNew('Date et Heure', 'datetime_value');
        $this->createNew('Adresse IP', 'ipaddress_value');
        $this->createNew('Valeur JSON', 'json_value');

        //TODO: Ajouter un type "sous-liste"
    }

    private function createNew($nom, $code) {
        AttributValueType::create(['nom' => $nom, 'code' => $code,'status_id' => Status::default()->first()->id]);
    }
}
