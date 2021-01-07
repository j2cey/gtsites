<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ElementSettingType;

class ElementSettingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("Province", "");// AttributValueType: 9
        $this->createNew("Site", "");// AttributValueType: 10
        $this->createNew("Centre Technique", "");// AttributValueType: 11
        $this->createNew("Type Pylône", "");// AttributValueType: 12
        $this->createNew("Type Site", "");// AttributValueType: 13
    }

    private function createNew($nom, $description) {
        ElementSettingType::create(['nom' => $nom, 'code' => Str::slug($nom, '-'), 'description' => $description,'status_id' => Status::default()->first()->id]);
    }
}
