<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property string $company
 * @property string $content
 * @property string $state
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 */
class Contact extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'tel', 'email', 'company', 'content', 'state', 'remark', 'created_at', 'updated_at'];
}
