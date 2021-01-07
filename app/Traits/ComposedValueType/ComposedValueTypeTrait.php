<?php


namespace App\Traits\ComposedValueType;

use App\Models\AttributValueType;

trait ComposedValueTypeTrait
{
    /**
     * Retourne le nom de la table du modèle qui aura les instances du type composé
     * @return string
     */
    abstract protected function valueTypeTableName(): string;

    /**
     * Retourne le nom de la classe du modèle qui aura les instances du type composé
     * @return string
     */
    abstract protected function valueTypeClassName(): string;

    /**
     * Retourne le nom du champs libellé de la classe qui aura les instances du type composé
     * @return string
     */
    abstract protected function valueTypeFieldLabel(): string;

    /**
     * Retourne le libellé du type composé
     * @return string
     */
    abstract protected function labelValue(): string;

    /**
     * Retourne le nom du champs de filtre
     * @return string
     */
    abstract protected function filterField(): string;

    /**
     * Retourne la valeur du champs de filtre
     * @return mixed
     */
    abstract protected function filterFieldvalue();

    public function addValueType() {
        $valuetype = new AttributValueType();
        $valuetype->nom = $this->labelValue() . " " . config('Settings.value_type.composed_type_suffix');
        $valuetype->code = $this->labelValue() . '_composed_type';
        $valuetype->est_compose = true;
        $valuetype->model_id = $this->id;
        $valuetype->model_classname = $this->valueTypeClassName();
        $valuetype->model_tablename = $this->valueTypeTableName();
        $valuetype->model_fieldlabel = $this->valueTypeFieldLabel();
        $valuetype->model_filterfield = $this->filterFieldvalue();
        $valuetype->model_filterfieldvalue = $this->filterField();

        $valuetype->save();
    }

    public function updateValueType() {

    }

    public function createOrUpdateValueType() {
        $valuetype = AttributValueType::updateOrCreate(
            [
                'nom' => $this->labelValue() . " " . config('Settings.value_type.composed_type_suffix'),
                'code' => $this->labelValue() . '_composed_type',
                'est_compose' => true,
                'model_id' => $this->id,
                'model_classname' => $this->valueTypeClassName(),
                'model_tablename' => $this->valueTypeTableName(),
                'model_fieldlabel' => $this->valueTypeFieldLabel(),
                'model_filterfield' => $this->filterField(),
                'model_filterfieldvalue' => $this->filterFieldvalue(),
            ]
        );
    }
}
