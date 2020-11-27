<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class BordereauremiseModepaie
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
class BordereauremiseModepaie extends BaseModel
{
    use HasFactory;
    protected $guarded = [];

    #region Eloquent Relationships

    public function bordereauremises() {
        return $this->hasMany(Bordereauremise::class, 'bordereauremise_modepaie_id');
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant enregistrement
        self::saving(function($model){
            $bordereauremises = $model->bordereauremises();
            if ($bordereauremises) {
                foreach ($bordereauremises as $bordereauremise) {
                    if (isset($bordereauremise->localisation_titre)) {
                        $bordereauremise->update([
                            'modepaiement_titre' => $model->titre
                        ]);
                    }
                }
            }
        });
    }
}
