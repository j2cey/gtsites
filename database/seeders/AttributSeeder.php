<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Attribut;
use Illuminate\Database\Seeder;

class AttributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Type Elément: Site, id 1
        $this->createNew('Nom', 1, 1, 0, true, false);
        $this->createNew('Province', 1, 9, 1,false, false);
        $this->createNew('Centre Technique', 1, 11, 2,false, false);
        $this->createNew('Type Pylône', 1, 12, 3,false, false);
        $this->createNew('Hauteur Pylône', 1, 3, 3,false, false);
        $this->createNew('Type Site', 1, 13, 4,false, false);
        $this->createNew('Contrat', 1, 1, 5,false, false, 'oui/propriétaire...');

        // Type Elément: BTS, id 2
        $this->createNew('Modèle BTS', 2, 1, 0,true, false);
        $this->createNew('Type BTS', 2, 1, 1,false, false);
        $this->createNew('Technologie BTS', 2, 1, 2,false, false);
        $this->createNew('Date mise en service', 2, 6, 3,false, false);

        // Type Elément: Transmission, id 3
        $this->createNew('Type Trans.FO/FH IP', 3, 1, 0,true, false);
        $this->createNew('Type Trans. Backbone', 3, 1, 1,false, false);
        $this->createNew('Type Trans. VSAT', 3, 1, 2,false, false);

        // Type Elément: Environnement, id 4
        $this->createNew('Config Energie', 4, 1, 0,true, false);
        $this->createNew('Capacité GE/Marque', 4, 1, 1,false, false);
        $this->createNew('Materiel', 4, 1, 2,false, false);
        $this->createNew('QTE', 4, 3, 3,false, false);
        $this->createNew('Marque', 4, 1, 4,false, false);
        $this->createNew('Puissance', 4, 1, 5,false, false);
        $this->createNew('Prestataire', 4, 1, 6,false, false);

        // Type Elément: Securite, id 5
        $this->createNew('Sécurité Site', 5, 1, 0,true, false);
        $this->createNew('Contact gardien 1', 5, 1, 1,false, false);
        $this->createNew('Contact gardien 2', 5, 1, 2,false, false);
    }

    private function createNew($nom, $type_element_id, $attribut_value_type_id, $ord, $est_libelle = false, $obligatoire = false, $description = "") {
        Attribut::create(
            [
                'nom' => $nom, 'type_element_id' => $type_element_id,
                'attribut_value_type_id' => $attribut_value_type_id, 'est_libelle' => $est_libelle,
                'obligatoire' => $obligatoire, 'description' => $description, 'ord' => $ord,
                'status_id' => Status::default()->first()->id
            ]
        );
    }
}
