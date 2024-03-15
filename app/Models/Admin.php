<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $username
 * @property string $email
 * @property integer $is_show
 * @property integer $group_id
 * @property string $login_permission
 * @property string $email_verified_at
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 */
class Admin extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'password', 'username', 'email', 'is_show', 'group_id', 'login_permission', 'email_verified_at', 'remember_token', 'created_at', 'updated_at'];
    public function group()
    {
        return $this->belongsTo(AdminGroup::class, 'group_id', 'id');
    }
}
