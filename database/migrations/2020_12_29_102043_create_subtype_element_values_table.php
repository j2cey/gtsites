<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateSubtypeElementValuesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'subtype_element_values';
    public $table_comment = 'valeur de l occurrence d une relation de sous-type d element';

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

            $table->foreignId('element_id')->nullable()
                ->comment('reference de l element')
                ->constrained()->onDelete('set null');

            $table->foreignId('subtype_element_id')->nullable()
                ->comment('reference de la relation de sous-type')
                ->constrained('subtype_elements')->onDelete('set null');

            $table->foreignId('sub_element_id')->nullable()
                ->comment('reference du sous-élément')
                ->constrained('elements')->onDelete('set null');
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
            $table->dropForeign(['element_id']);
            $table->dropForeign(['subtype_element_id']);
            $table->dropForeign(['sub_element_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
