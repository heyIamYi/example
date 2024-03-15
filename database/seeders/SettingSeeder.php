<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/json/setting.json'), true);
        $this->migrate($datas);
    }

    public function migrate($datas)
    {
        foreach ($datas as $data) {
            Setting::create($data);
        }
    }
}
