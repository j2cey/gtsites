<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class BordereauremiseType
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $code
 * @property string $titre
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BordereauremiseType extends BaseModel
{
    use HasFactory;
    protected $guarded = [];
}
