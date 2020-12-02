<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LdapAccountImport
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string|null $objectguid
 * @property string|null $username
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class LdapAccountImport extends Model implements Auditable
{
    use HasFactory, LogsActivity, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    #region Spatie LogsActivity

    protected static $logAttributes = ['*'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Action sur [Importation Compte LDAP]: {$eventName}";
    }

    #endregion
}
