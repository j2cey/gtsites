<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\Ordonable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SubtypeElement
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
 *
 * @property integer|null $type_element_id
 * @property integer|null $subtype_element_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SubtypeElement extends BaseModel
{
    use HasFactory, Ordonable;

    protected $guarded = [];

    protected function tableName()
    {
        return "subtype_elements";
    }

    #region Validation Rules

    public static function defaultRules() {
        return [
            'nom' => 'required',
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
     * Retourne le sous-type d'élément du type d'élément
     * @return BelongsTo
     */
    public function subtype() {
        return $this->belongsTo(TypeElement::class, 'subtype_element_id');
    }

    #endregion
}
