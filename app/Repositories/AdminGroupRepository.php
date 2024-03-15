<?php

namespace App\Repositories;

use App\Models\AdminGroup;
use App\Repositories\BaseRepository;

class AdminGroupRepository extends BaseRepository
{

    public function __construct(AdminGroup $model)
    {
        parent::__construct($model);
    }

}
