<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/json/menus.json'));

        $this->migrate($datas);

        foreach ($datas as $data) {
            if (isset($data->child) && !empty($data->child)) {
                $parent = Menu::where('name', $data->name)->first();
                foreach ($data->child as $child) {
                    $this->migrate([$child], $parent->id);
                }
            }
        }

    }

    public function migrate($datas, $parent_id = 0)
    {
        foreach ($datas as $data) {
           Menu::firstOrCreate([
                'name'      => $data->name,
                'alias'      => $data->alias ?? '',
                'hide_sub'  => $data->hide_sub ?? 1,
                'parent_id' => $parent_id,
                'slist'     => $data->slist ?? 1,
                'sadd'      => $data->sadd ?? 1,
                'sedit'     => $data->sedit ?? 1,
                'sdelete'   => $data->sdelete ?? 1,
                'sort'      => $data->sort ?? 100,
            ]);
        }
    }
}
