<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\ModelNameGeneratorTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MakeAllAdminController extends Command
{
    use ModelNameGeneratorTrait;

    protected $signature = 'make:all-resources';

    protected $description = 'Generate models, controllers, and views based on the table name format';

    public function handle()
    {
        $tables = $this->getTableArray();

        // 生成Model
        foreach ($tables as $table) {
            $this->generateModelForTable($table);
        }

        // 生成controller和view
        foreach ($tables as $tablename) {
            $modelName = $this->generateModelName($tablename);
            $this->createControllerFromStub('Controller.stub', $modelName, $tablename);

            // 生成view
            $this->createViews('List.stub', 'list', $tablename);
            $this->createViews('Form.stub', 'form', $tablename);
        }

        $this->info('All resources generated successfully!');
    }

    // 檢查Model是否存在
    protected function generateModelForTable($tablename)
    {
        $modelName = $this->generateModelName($tablename);
        if (!$this->modelExists($modelName)) {
            $this->info("Generating model {$modelName} for table {$tablename}...");
            $this->call('krlove:generate:model', [
                'class-name' => $modelName,
                '--table-name' => $tablename
            ]);
        } else {
            $this->info("Model {$modelName} already exists, skipping...");
        }
    }

    // 判斷Model文件是否存在
    protected function modelExists($modelName)
    {
        $modelPath = app_path('/Models/' . $modelName . '.php');
        return File::exists($modelPath);
    }

    // 生成Controller
    protected function createControllerFromStub($stubName, $modelName, $tablename)
    {
        $stubPath = app_path('stubs/' . $stubName);
        $controllerDir = app_path('Http/Controllers/');
        if (!File::exists($controllerDir)) {
            File::makeDirectory($controllerDir, 0755, true);
        }

        $content = File::get($stubPath);
        $content = str_replace(['{{ModelName}}', '{{TableName}}'], [$modelName, $tablename], $content);

        $filePath = $controllerDir . '/WebAdmin/Admin' . $modelName . 'Controller.php';
        if (File::exists($filePath)) {
            $this->warn($filePath . ' already exists! Skipping...');
            return;
        }

        File::put($filePath, $content);
        $this->line($filePath . ' created.');
    }

    // 生成View
    protected function createViews($stubName, $type, $tableName)
    {
        $stubPath = app_path('stubs/' . $stubName);
        $viewDir = resource_path('views/back/' . $type);
        if (!File::exists($viewDir)) {
            File::makeDirectory($viewDir, 0755, true);
        }

        $content = File::get($stubPath);
        $filePath = $viewDir . '/' . $tableName . '.blade.php';
        if (File::exists($filePath)) {
            $this->warn($filePath . ' already exists! Skipping...');
            return;
        }

        File::put($filePath, $content);
        $this->line($filePath . ' created.');
    }

    // 資料表表名稱
    protected function getTableArray()
    {
        // 排除資料表
        $excludeTableName = [
            'migrations',
            'password_resets',
            'failed_jobs',
            'personal_access_tokens',
            'admins',
            'admin_groups',
            'admin_group_perms',
            'languages',
            'metas',
            'menus',
            'settings',
            'contacts',
            'contact_mails',
        ];

        // 取得資料庫內$excludeTableName以外的, 所有資料表
        $tables = DB::select('SHOW TABLES');
        $tableNames = [];
        foreach ($tables as $table) {
            $tableName = reset($table);
            if (!in_array($tableName, $excludeTableName)) {
                $tableNames[] = $tableName;
            }
        }
        return $tableNames;
    }
}
