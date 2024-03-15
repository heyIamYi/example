<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property string $page_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $page_script
 * @property string $created_at
 * @property string $updated_at
 */
class Meta extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'page_title', 'meta_keywords', 'meta_description', 'page_script', 'created_at', 'updated_at'];
}
