<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateElementSettingsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'element_settings';
    public $table_comment = 'paramètres d élément';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->foreignId('element_setting_type_id')->nullable()
                ->comment('reference du type de parametre l element')
                ->constrained()->onDelete('set null');

            $table->string('nom')->comment('nom du parametre d element');
            $table->string('code')->comment('code du parametre d element');
            $table->string('description')->nullable()->comment('description du parametre d element');
            $table->unique(['element_setting_type_id', 'code']);
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
            $table->dropForeign(['element_setting_type_id']);
            $table->dropIndex('element_settings_element_setting_type_id_code_unique');
        });
        Schema::dropIfExists($this->table_name);
    }
}
