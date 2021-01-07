<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // groupe app_name, id: 1
        $this->createNew("app_name", null, "Gestion-Sites", "string", "Application Name.");

        // groupe ldap, id: 2
        $this->createNew("ldap", null, null, null, "settings LDAP.");
        $this->createNew("liste_sigles", 2, "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", "array", "liste des sigles (à prendre en compte dans l importation LDAP).");

        // groupe roles, id: 4
        $this->createNew("roles", null, null, null, "settings Roles.");
        $this->createNew("default", 4, "1", "integer", "Role par défaut à la creéation d un utilisateur dont le role n est pas explicitement déterminé.");

        // groupe value_type, id: 6
        $this->createNew("value_type", null, null, null, "settings Value Type.");
        $this->createNew("composed_type_suffix", 6, "(Type Composé)", "string", "Suffixe ajouté au nom d un type de valeur composé");

        $settings = [
            [ 'name' => "ldap", 'description' => "settings LDAP." ], // 1
            [
                'group_id' => 1, 'name' => "liste_sigles", 'value' => "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", 'type' => "array", 'description' => "liste des sigles (à prendre en compte dans l importation LDAP)."
            ],
            [ 'name' => "roles", 'description' => "settings Roles." ], // 3
            [
                'group_id' => 3, 'name' => "default", 'value' => "1", 'type' => "integer", 'description' => "Role par défaut à la creéation d un utilisateur dont le role n est pas explicitement déterminé."
            ],

            [ 'name' => "app_name", 'value' => "Gest-Bordereaux-Remise", 'description' => "settings LDAP." ], // 1
            [ 'name' => "value_type", 'description' => "settings Value Type." ], // 11
        ];
        /*foreach ($settings as $setting) {
            Setting::create($setting);
        }*/
    }

    private function createNew($name, $group_id = null, $value = null, $type = null, $description = null) {
        $data = ['name'  => $name];
        if (! is_null($group_id)) { $data['group_id'] = $group_id; }
        if (! is_null($value)) { $data['value'] = $value; }
        if (! is_null($type)) { $data['type'] = $type; }
        if (! is_null($description)) { $data['description'] = $description; }
        Setting::create($data);
    }
}
