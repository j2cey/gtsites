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
}
