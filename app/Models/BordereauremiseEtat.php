<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class BordereauremiseEtat
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 * @property string $code
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BordereauremiseEtat extends BaseModel
{
    use HasFactory;
    protected $guarded = [];

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }
}
