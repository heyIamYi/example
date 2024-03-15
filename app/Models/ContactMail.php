<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $sort
 * @property string $address
 * @property integer $is_show
 * @property string $created_at
 * @property string $updated_at
 */
class ContactMail extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'address', 'is_show', 'sort', 'created_at', 'updated_at'];
}
