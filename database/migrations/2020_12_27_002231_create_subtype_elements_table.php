<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateSubtypeElementsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'subtype_elements';
    public $table_comment = 'liste des sous-type (liaison) d un type d element du système donné';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtype_elements', function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->string('nom')->comment('nom du sous-type');
            $table->boolean('obligatoire')->default(false)->comment('détermine si le sous-type est obliggatoire');
            $table->integer('ord')->default(0)->comment('numéro d ordre du sous-type. Base 0');
            $table->string('description')->nullable()->comment('description du sous-type');

            $table->foreignId('type_element_id')->nullable()
                ->comment('reference du type d element')
                ->constrained('type_elements')->onDelete('set null');

            $table->foreignId('subtype_element_id')->nullable()
                ->comment('reference du sous-type d element')
                ->constrained('type_elements')->onDelete('set null');
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
            $table->dropForeign(['subtype_element_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
