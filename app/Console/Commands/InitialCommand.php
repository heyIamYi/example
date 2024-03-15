<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create some info in SQL table';

    protected $seeders = [
        'AdminSeeder',
        'MenuSeeder',
        'GroupSeeder',
        'SettingSeeder',
        'MetaSeeder',
        'LanguageSeeder',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 取得所有的資料表
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        // 禁用外鍵
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 清空每個資料表
        foreach ($tableNames as $name) {
            // 確定該表不是系統的保留表
            if ($name == "migrations") {
                continue;
            }
            DB::table($name)->truncate();
        }

        // 啟用外鍵
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call('migrate');
        $this->call('migrate:refresh');

        foreach ($this->seeders as $seeder) {
            $this->call('db:seed', [
                '--class' => $seeder,
            ]);
        }
        return 0;
    }
}
