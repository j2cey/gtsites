<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateElementSettingTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'element_setting_types';
    public $table_comment = 'types de paramètre d élément';

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

            $table->string('nom')->unique()->comment('nom du type de parametre d element');
            $table->string('code')->unique()->comment('code du type de parametre d element');
            $table->string('description')->nullable()->comment('description du type de parametre d element');
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
        });
        Schema::dropIfExists($this->table_name);
    }
}
