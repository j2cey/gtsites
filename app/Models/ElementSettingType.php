<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\ComposedValueType\IsComposedValueType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ElementSettingType
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
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ElementSettingType extends BaseModel
{
    use HasFactory, IsComposedValueType;

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

    #region IsComposedValueType Implementation

    protected function valueTypeTableName(): string
    {
        return "element_settings";
    }

    protected function valueTypeClassName(): string
    {
        return "App\Models\ElementSetting";
    }

    protected function valueTypeFieldLabel(): string
    {
        return "nom";
    }

    protected function labelValue(): string
    {
        return $this->nom;
    }

    protected function filterField(): string
    {
        return "element_setting_type_id";
    }

    protected function filterFieldvalue()
    {
        return $this->id;
    }

    #endregion
}
