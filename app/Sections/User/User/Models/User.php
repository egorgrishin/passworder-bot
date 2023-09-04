<?php

namespace Sections\User\User\Models;

use App\Parents\BaseModel;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int                    $id
 * @property string                 $name
 * @property string                 $email
 * @property DateTimeInterface|null $email_verified_at
 * @property string                 $role_type
 * @property string                 $password
 * @property DateTimeInterface      $created_at
 * @property DateTimeInterface      $updated_at
 * @property DateTimeInterface|null $deleted_at
 */
class User extends BaseModel
{
    use SoftDeletes;
}
