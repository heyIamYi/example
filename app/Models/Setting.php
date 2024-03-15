<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminGroupPerm;

/**
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property boolean $serialized
 * @property string $created_at
 * @property string $updated_at
 */
class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['key', 'value', 'serialized', 'created_at', 'updated_at'];


}
