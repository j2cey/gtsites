<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAttributValuesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'attribut_values';
    public $table_comment = 'valeur de l attribut d un element';

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

            $table->foreignId('attribut_id')->nullable()
                ->comment('reference de l attribut')
                ->constrained()->onDelete('set null');

            $table->string('string_value')->nullable()->comment('STRING equivalent value');
            $table->bigInteger('biginteger_value')->nullable()->comment('BIGINT equivalent value');
            $table->integer('integer_value')->nullable()->comment('INTEGER equivalent value');
            $table->binary('binary_value')->nullable()->comment('BLOB equivalent value');
            $table->boolean('boolean_value')->nullable()->comment('BOOLEAN equivalent value');
            $table->dateTime('datetime_value')->nullable()->comment('DATETIME equivalent value');
            $table->ipAddress('ipaddress_value')->nullable()->comment('IP address equivalent value');
            $table->json('json_value')->nullable()->comment('JSON equivalent value');
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
            $table->dropForeign(['attribut_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
