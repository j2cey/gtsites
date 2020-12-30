<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Element
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string $tags
 * @property integer|null $status_id
 *
 * @property integer|null $type_element
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Element extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [

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
     * Retourne le type d'élément de l'élément
     * @return BelongsTo
     */
    public function typeelement() {
        return $this->belongsTo(Element::class, 'type_element');
    }

    #endregion
}
