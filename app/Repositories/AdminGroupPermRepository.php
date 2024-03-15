<?php

namespace App\Repositories;

use App\Models\AdminGroupPerm;
use App\Repositories\BaseRepository;

class AdminGroupPermRepository extends BaseRepository
{

    public function __construct(AdminGroupPerm $model)
    {
        parent::__construct($model);
    }

}
