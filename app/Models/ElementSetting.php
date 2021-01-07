<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ElementSetting
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
 * @property string|null $description
 *
 * @property integer|null $element_setting_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ElementSetting extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'nom' => 'required',
            'code' => 'required',
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
     * Retourne le type de paramètre d'élément
     * @return BelongsTo
     */
    public function settingtype() {
        return $this->belongsTo(ElementSettingType::class, 'element_setting_type_id');
    }

    #endregion

    public function getLabelAttribute()
    {
        return $this->nom;
    }
}
