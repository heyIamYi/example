<?php

namespace App\Services\System;

use Illuminate\Support\Facades\File;
use App\Repositories\ContactRepository;
use App\Repositories\ContactMailRepository;
use App\Repositories\MetaRepository;
use App\Repositories\MenuRepository;
use App\Repositories\SettingRepository;
use App\Repositories\AdminGroupRepository;
use App\Repositories\AdminRepository;
use App\Repositories\AdminGroupPermRepository;
use App\Traits\MediaManagerTrait;
use App\Traits\ModelNameGeneratorTrait;

class BaseService
{
    use MediaManagerTrait, ModelNameGeneratorTrait;

    protected $metaRepo;
    protected $menuRepo;
    protected $adminGroupRepo;
    protected $adminRepo;
    protected $adminGroupPermRepo;
    protected $settingRepo;
    protected $contactRepo;
    protected $contactMailRepo;

    public function __construct(
        ContactRepository        $contactRepo,
        MetaRepository           $metaRepo,
        MenuRepository           $menuRepo,
        SettingRepository        $settingRepo,
        AdminGroupRepository      $adminGroupRepo,
        AdminRepository           $adminRepo,
        AdminGroupPermRepository $adminGroupPermRepo,
        ContactMailRepository    $contactMailRepo
    ){
        $this->contactRepo      = $contactRepo;
        $this->metaRepo         = $metaRepo;
        $this->settingRepo      = $settingRepo;
        $this->menuRepo         = $menuRepo;
        $this->adminGroupRepo    = $adminGroupRepo;
        $this->adminRepo         = $adminRepo;
        $this->adminGroupPermRepo     = $adminGroupPermRepo;
        $this->contactMailRepo  = $contactMailRepo;
    }
}
