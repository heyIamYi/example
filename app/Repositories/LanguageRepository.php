<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\BaseRepository;

class LanguageRepository extends BaseRepository
{

    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

}
