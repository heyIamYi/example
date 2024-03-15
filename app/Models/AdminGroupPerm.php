<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminGroup;
use App\Models\Menu;

/**
 * @property integer $id
 * @property integer $u_id
 * @property integer $group_id
 * @property integer $menu_id
 * @property boolean $s_tag
 * @property boolean $a_tag
 * @property boolean $e_tag
 * @property boolean $d_tag
 * @property string $created_at
 * @property string $updated_at
 */
class AdminGroupPerm extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['u_id', 'group_id', 'menu_id', 's_tag', 'a_tag', 'e_tag', 'd_tag', 'created_at', 'updated_at'];

    public function group()
    {
        return $this->belongsTo(AdminGroup::class, 'group_id', 'id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
