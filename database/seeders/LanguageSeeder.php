<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(base_path('database/seeders/json/language.json')), true);
        $this->migrate($data);
    }

    public function migrate($data)
    {
        foreach ($data as $item) {
            Language::create($item);
        }
    }
}
