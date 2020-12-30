<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAttributsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'attributs';
    public $table_comment = 'attribut d un type d élément';

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

            $table->string('nom')->comment('nom de l attribut');
            $table->boolean('obligatoire')->default(false)->comment('détermine si l attribut est obliggatoire');
            $table->integer('ord')->default(0)->comment('numéro d ordre de l attribut. Base 0');
            $table->string('description')->nullable()->comment('description de l attribut');
            $table->boolean('est_libelle')->default(false)->comment('détermine si l attribut fait partie du libelle de l object (element)');

            $table->foreignId('type_element_id')->nullable()
                ->comment('reference du type d element')
                ->constrained()->onDelete('set null');

            $table->foreignId('attribut_value_type_id')->nullable()
                ->comment('reference du type de valeur de l attribut')
                ->constrained()->onDelete('set null');
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
            $table->dropForeign(['type_element_id']);
            $table->dropForeign(['attribut_value_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
