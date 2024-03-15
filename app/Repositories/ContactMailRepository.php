<?php

namespace App\Repositories;

use App\Models\ContactMail;
use App\Repositories\BaseRepository;

class ContactMailRepository extends BaseRepository
{

    public function __construct(ContactMail $model)
    {
        parent::__construct($model);
    }

}
