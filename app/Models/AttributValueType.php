<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AttributValueType
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
 * @property bool $est_compose
 * @property integer|null $model_id
 * @property string|null $model_classname
 * @property string|null $model_tablename
 * @property string|null $model_fieldlabel
 * @property string|null $model_filterfield
 * @property string|null $model_filterfieldvalue
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AttributValueType extends BaseModel
{
    use HasFactory;

    protected $guarded = [];
}
