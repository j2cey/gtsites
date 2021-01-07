<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ComposedValueType\IsComposedValueType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TypeElement
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string $tags
 * @property integer|null $status_id
 *
 * @property string $nom
 * @property string|null $description
 * @property integer|null $user_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TypeElement extends BaseModel
{
    use HasFactory, IsComposedValueType;

    protected $guarded = [];

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
     * Retourne les attributs du type d élément
     * @return HasMany
     */
    public function attributs() {
        return $this->hasMany(Attribut::class)->orderBy('ord');
    }

    /**
     * Retourne les sous-type du type d éléments
     * @return HasMany
     */
    public function subtypes() {
        return $this->hasMany(SubtypeElement::class)->orderBy('ord');
    }

    #endregion

    #region IsComposedValueType Implementation

    protected function valueTypeTableName(): string
    {
        return "elements";
    }

    protected function valueTypeClassName(): string
    {
        return "App\Models\Element";
    }

    protected function valueTypeFieldLabel(): string
    {
        return "";
    }

    protected function labelValue(): string
    {
        return $this->nom;
    }

    protected function filterFieldvalue()
    {
        return $this->id;
    }

    protected function filterField(): string
    {
        return "type_element_id";
    }

    #endregion
}
