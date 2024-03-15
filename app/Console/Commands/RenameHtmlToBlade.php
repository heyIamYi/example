<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenameHtmlToBlade extends Command
{
    protected $signature = 'rename:file-to-blade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename all .html or .php views to .blade.php';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appName = env('APP_NAME');
        $files = File::allFiles(resource_path('views/' . $appName));

        foreach ($files as $file) {
            if (pathinfo($file)['extension'] === 'html' || pathinfo($file)['extension'] === 'php') {
                $newName = pathinfo($file)['dirname'] . '/' . pathinfo($file)['filename'] . '.blade.php';
                File::move($file, $newName);
                $this->info("Renamed {$file} to {$newName}");
            }
        }

        return 0;
    }
}
