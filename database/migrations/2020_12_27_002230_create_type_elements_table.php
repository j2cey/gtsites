<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTypeElementsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'type_elements';
    public $table_comment = 'type d element du système';

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

            $table->string('nom')->comment('nom du type d element');
            $table->string('description')->nullable()->comment('description type d element');

            $table->foreignId('user_id')->nullable()
                ->comment('reference user')
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
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
