<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowObjectField
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $db_field_name
 * @property string $field_label
 *
 * @property boolean|null $valuetype_string
 * @property boolean|null $valuetype_integer
 * @property boolean|null $valuetype_boolean
 * @property boolean|null $valuetype_datetime
 * @property boolean|null $valuetype_image
 *
 * @property integer|null $workflow_object_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowObjectField extends BaseModel
{
    use HasFactory, LogsActivity;
    protected $guarded = [];

    #region Spatie LogsActivity

    protected static $logAttributes = ['*'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Action sur [Champs d Objet de Workflow]: {$eventName}";
    }

    #endregion

    #region Eloquent Relationships

    public function object() {
        return $this->belongsTo(WorkflowObject::class, 'workflow_object_id');
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant enregistrement
        self::saving(function($model){
            $model->field_label = $model->object->model_title . " | " . $model->field_label;
        });
    }
}
