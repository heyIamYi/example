<?php

namespace Database\Seeders;

use App\Models\Meta;
use Illuminate\Database\Seeder;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/json/meta.json'));

        $this->migrate($datas);
    }

    public function migrate($datas)
    {
        foreach ($datas as $data) {
            $parent = Meta::firstOrCreate([
                'title'      => $data->title,
            ]);
        }
    }
}
