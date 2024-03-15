<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        // 檢查 $name 是否包含 "service" (不論大小寫)
        if (stripos($name, 'service') === false) {
            $servicePath = app_path('Services') . '/' . $name . 'Service.php';
            $name = $name . 'Service';
        } else {
            $servicePath = app_path('Services') . '/' . $name . '.php';
        }
        $firstChar = substr($name, 0, 1);

        if (ctype_lower($firstChar)) {
            echo "Error: Class name should start with an uppercase letter.";
        } else {

            if (File::exists($servicePath)) {
                $this->error('Service already exists!');
                return;
            }

            $stub = $this->generateStub($name);

            File::put($servicePath, $stub);

            $this->info('Service created successfully!');
        }

    }

    private function generateStub($name)
    {
        $stub = File::get('app/stubs/service.stub');
        $stub = str_replace('{{name}}', $name, $stub);

        return $stub;
    }

}
