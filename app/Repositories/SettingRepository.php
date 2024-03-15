<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\BaseRepository;

class SettingRepository extends BaseRepository
{

    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

}
