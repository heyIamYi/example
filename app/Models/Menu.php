<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminGroupPerm;

/**
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $alias
 * @property integer $sort
 * @property integer $hide_sub
 * @property integer $slist
 * @property integer $sadd
 * @property integer $sedit
 * @property integer $sdelete
 * @property integer $control
 * @property string $created_at
 * @property string $updated_at
 */
class Menu extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'parent_id', 'alias', 'sort', 'hide_sub', 'slist', 'sadd', 'sedit', 'sdelete', 'control', 'created_at', 'updated_at'];
    public function groupPerms()
    {
        return $this->hasMany(AdminGroupPerm::class, 'menu_id', 'id');
    }

    // 自參考表
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
}
