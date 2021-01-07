<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AttributValue
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string $tags
 * @property integer|null $status_id
 *
 * @property integer|null $string_value
 * @property integer|null $biginteger_value
 * @property integer|null $integer_value
 * @property string|null $binary_value
 * @property bool|null $boolean_value
 * @property Carbon|null $datetime_value
 * @property string|null $ipaddress_value
 * @property string|null $json_value
 *
 * @property integer|null $attribut_id
 * @property integer|null $element_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AttributValue extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Retourne l'attribut qui a cette valeur
     * @return BelongsTo
     */
    public function attribut() {
        return $this->belongsTo(Attribut::class, 'attribut_id');
    }

    /**
     * Retourne l'élément
     * @return BelongsTo
     */
    public function element() {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function getValue() {
        if ($this->attribut->valuetype->code === "boolean_value") {
            // Type Booleen
            return $this->boolean_value;
        } elseif ($this->attribut->valuetype->code === "datetime_value") {
            // Type DateTime
            return $this->datetime_value;
        } elseif ($this->attribut->valuetype->code === "string_value") {
            // Type string
            return $this->string_value;
        } elseif ($this->attribut->valuetype->code === "integer_value") {
            // Type integer
            return $this->integer_value;
        } elseif ($this->valuetype->code === "biginteger_value") {
            // Type integer
            return $this->biginteger_value;
        } else {
            return null;
        }
    }
}
