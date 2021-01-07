<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\Ordonable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Attribut
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string $tags
 * @property integer|null $status_id
 *
 * @property string $nom
 * @property string $code
 * @property boolean $obligatoire
 * @property integer $ord
 * @property string|null $description
 * @property boolean $est_libelle
 *
 * @property integer|null $type_element_id
 * @property integer|null $attribut_value_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Attribut extends BaseModel
{
    use HasFactory, Ordonable;

    protected $guarded = [];

    protected function tableName()
    {
        return "attributs";
    }

    #region Validation Rules

    public static function defaultRules() {
        return [
            'nom' => 'required',
            'valuetype' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    #endregion

    #region Eloquent Relationships

    /**
     * Retourne le type d'élément de l'attribut
     * @return BelongsTo
     */
    public function typeelement() {
        return $this->belongsTo(TypeElement::class, 'type_element_id');
    }

    /**
     * Retourne le type de valeur de l'attribut
     * @return BelongsTo
     */
    public function valuetype() {
        return $this->belongsTo(AttributValueType::class, 'attribut_value_type_id');
    }

    #endregion

    #region custom functions

    public function setValue($element_id, $val) {
        //$input_vals = $request->all();
        //$val = isset($input_vals[$this->uuid]) ? $input_vals[$this->uuid] : "";
        $attributvalue = new AttributValue([
            'element_id' => $element_id,
            'attribut_id' => $this->id,
        ]);
        $nb_set = 0;
        if ($this->valuetype->est_compose) {

        } elseif ($this->valuetype->code === "boolean_value") {
            // Type Booleen
            $bool_val = ($val === "null" || $val === null || $val === "false" || $val === "") ? 0 : 1;
            $attributvalue->boolean_value = $bool_val;
            $nb_set++;
        } elseif ($this->valuetype->code === "datetime_value") {
            // Type DateTime
            if (! empty($val)) {
                $attributvalue->datetime_value = $val; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
                $nb_set++;
            }
        } elseif ($this->valuetype->code === "string_value") {
            // Type string
            $str_val = ($val === "null" || $val === null) ? "" : $val;
            $attributvalue->string_value = $str_val;
            $nb_set++;
        } elseif ($this->valuetype->code === "integer_value") {
            // Type integer
            $str_val = ($val === "null" || $val === null || $val === null) ? 0 : (int)$val;
            $attributvalue->integer_value = $str_val;
            $nb_set++;
        } elseif ($this->valuetype->code === "biginteger_value") {
            // Type integer
            $str_val = ($val === "null" || $val === null || $val === null) ? 0 : (int)$val;
            $attributvalue->biginteger_value = $str_val;
            $nb_set++;
        } else {
            $nb_set = 0;
        }

        if ($nb_set > 0) {
            $attributvalue->save();
        }

        return $nb_set;
    }

    #endregion
}
