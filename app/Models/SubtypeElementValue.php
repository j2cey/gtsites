<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SubtypeElementValue
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string $tags
 * @property integer|null $status_id
 *
 * @property integer|null $element_id
 * @property integer|null $subtype_element_id
 * @property integer|null $sub_element_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SubtypeElementValue extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Retourne l'élément qui a cette occurrence
     * @return BelongsTo
     */
    public function element() {
        return $this->belongsTo(Element::class, 'element_id');
    }

    /**
     * Retourne l'élément qui a cette occurrence
     * @return BelongsTo
     */
    public function subelement() {
        return $this->belongsTo(Element::class, 'element_id');
    }
}
