<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    use HasFactory, LogsActivity;
    protected $guarded = [];

    #region Spatie LogsActivity

    protected static $logAttributes = ['*'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Action sur [Etat de Bordereau de Remise]: {$eventName}";
    }

    #endregion

    #region Scopes

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }

    #endregion
}
