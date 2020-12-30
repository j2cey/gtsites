<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\Ordonable;
use Illuminate\Database\Eloquent\Model;
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
}
