<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAttributValueTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'attribut_value_types';
    public $table_comment = 'type de valeur d un attribut';

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

            $table->string('nom')->comment('nom du type de valeur');
            $table->string('code')->comment('code du type de valeur');
            $table->string('description')->nullable()->comment('description du type de valeur');

            $table->boolean('est_compose')->default(false)->comment('détermine si ce type est simple ou composé');
            $table->string('model_id')->nullable()->comment('id du modèle (cas de type composé)');
            $table->string('model_classname')->nullable()->comment('nom de la classe du modèle (cas de type composé)');
            $table->string('model_tablename')->nullable()->comment('nom de la table du modèle (cas de type composé)');
            $table->string('model_fieldlabel')->nullable()->comment('nom du champs libellé du modèle (cas de type composé)');
            $table->string('model_filterfield')->nullable()->comment('champs de filtre, le cas échéant (cas de type composé)');
            $table->string('model_filterfieldvalue')->nullable()->comment('valeur du champs de filtre, le cas échéant (cas de type composé)');
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
