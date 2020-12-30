<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Element;
use Illuminate\Database\Seeder;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    }

    private function createNew($nom) {
        Element::create(['nom' => $nom,'status_id' => Status::default()->first()->id]);
    }
}
