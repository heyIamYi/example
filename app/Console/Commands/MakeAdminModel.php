<?php

namespace App\Console\Commands;

use App\Traits\ModelNameGeneratorTrait;
use Illuminate\Console\Command;

class MakeAdminModel extends Command
{
    use ModelNameGeneratorTrait;

    protected $signature = 'admin:model:gen';

    protected $description = 'Automatically generate models for predefined tables';

    public function handle()
    {
        $tables = $this->getTableArray();
        foreach ($tables as $table) {
            $this->generateModelForTable($table);
        }
    }

    protected function generateModelForTable($tablename)
    {
        $modelName = $this->generateModelName($tablename);

        // 檢查模型文件是否已存在
        if (file_exists(app_path('Models/' . $modelName . '.php'))) {
            $this->info("Model {$modelName} already exists. Skipping...");
            return;
        }

        $this->info("Generating model {$modelName} for table {$tablename}...");

        $this->call('krlove:generate:model', [
            'class-name' => $modelName,
            '--table-name' => $tablename,
        ]);
    }

    protected function getTableArray()
    {
        return [
            'admins',
            'admin_groups',
            'admin_group_perms',
            'contacts',
            'contact_mails',
            'languages',
            'metas',
            'menus',
            'settings',
        ];
    }
}
