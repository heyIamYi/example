<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $leanguage
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 */
class Language extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['leanguage', 'code', 'created_at', 'updated_at'];
}
