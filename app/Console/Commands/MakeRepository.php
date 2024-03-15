<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'repo:gen-all';

    protected $description = 'Create a new Repository class';

    public function handle()
    {

        // 資料夾創建
        $repositoriesDir = app_path('Repositories');
        if (!file_exists($repositoriesDir)) {
            mkdir($repositoriesDir, 0755, true);
            echo "Created 'Repositories' directory.\n";
        }

        // 要排除的Models
        $excludedModels = [
            // 'App\Models\Meta',
            // 'App\Models\Admin',
            // 'App\Models\Setting',
            // 'App\Models\AdminGroup',
            // 'App\Models\AdminGroupPerm',
        ];

        $modelClasses = array_diff($this->getAllModelClasses(), $excludedModels);

        if (empty($modelClasses)) {
            echo '目前沒有需要產生的Model';
            return;
        }

        foreach ($modelClasses as $modelClass) {
            if (!$this->modelExists($modelClass)) {
                $this->info("Model '{$modelClass}' does not exist. Generating it...");
                $this->call('model:gen-all');  // 生成所有model的命令
            }
            $this->generateRepository($modelClass);
        }
    }

    private function modelExists($modelClass)
    {
        return class_exists($modelClass);
    }

    private function generateRepository($modelClass)
    {
        $name = class_basename($modelClass);
        $repositoryPath = app_path('Repositories') . '/' . $name . 'Repository.php';

        $firstChar = substr($name, 0, 1);
        if (ctype_lower($firstChar)) {
            $this->error('Error: Class name should start with a capital letter.');
            return;
        } elseif (is_numeric($firstChar)) {
            $this->error('Error: Class name should start with an alphabetic character.');
            return;
        }

        // 檢查是否已經存在
        if (File::exists($repositoryPath)) {
            $this->warn("Warning: Repository for '{$name}' already exists! Skipping...");
            return;
        }

        $stub = $this->generateStub($name, $modelClass);

        File::put($repositoryPath, $stub);

        $this->info("Repository '{$name}' created successfully!");
    }

    private function generateStub($name, $modelClass)
    {
        $stub = File::get('app/stubs/Repository.stub');
        $stub = str_replace(
            ['{{name}}', '{{ModelName}}'],
            [$name, ucfirst($name), '$' . lcfirst($name)],
            $stub
        );

        $modelNamespace = implode('\\', array_slice(explode('\\', $modelClass), 0, -1));
        $stub = str_replace('{{ModelNamespace}}', $modelNamespace, $stub);

        return $stub;
    }

    private function getAllModelClasses()
    {
        $modelPath = app_path('Models');
        $modelFiles = File::files($modelPath);

        $modelClasses = [];
        foreach ($modelFiles as $modelFile) {
            $modelPath = $modelFile->getRelativePathName();
            $modelClass = 'App\\Models\\' . pathinfo($modelPath, PATHINFO_FILENAME);
            $modelClasses[] = $modelClass;
        }

        return $modelClasses;
    }
}
