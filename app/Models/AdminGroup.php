<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminGroupPerm;
use App\Models\Admin;
/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class AdminGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at'];
    public function groupPerms()
    {
        return $this->hasMany(AdminGroupPerm::class, 'group_id', 'id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'group_id', 'id');
    }
}
