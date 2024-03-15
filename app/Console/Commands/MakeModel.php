<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\ModelNameGeneratorTrait;
use Illuminate\Support\Facades\File;

class MakeModel extends Command
{
    use ModelNameGeneratorTrait;

    protected $signature = 'model:gen-all';

    protected $description = 'Automatically generate a model based on the table name format';

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

    protected function modelExists($modelName)
    {
        $modelPath = app_path('Models/' . $modelName . '.php');
        return File::exists($modelPath);
    }


    protected function getTableArray()
    {
            return [
                'abouts',
                'news_categories',
                'news',
                'case_categories',
                'case_lists',
                'services'
            ];
    }
}
