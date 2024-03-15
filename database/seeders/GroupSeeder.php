<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminGroup;
use App\Models\AdminGroupPerm;
use App\Models\Menu;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/adminGroup.json'), true);
        $this->migrate($data);
    }

    public function migrate($data)
    {
        foreach ($data as $item)
        {
            $group = AdminGroup::create($item);
            $Menus = Menu::all();
            foreach ($Menus as $menu) {
                $sTag = ($menu->alias == null) ? 1 : 1;
                $aTag = ($menu->alias == null) ? null : 1;
                $eTag = ($menu->alias == null) ? null : 1;
                $dTag = ($menu->alias == null) ? null : 1;

                AdminGroupPerm::create([
                    'group_id' => $group->id,
                    'menu_id'  => $menu->id,
                    's_tag'    => $sTag,
                    'a_tag'    => $aTag,
                    'e_tag'    => $eTag,
                    'd_tag'    => $dTag,
                ]);
            }

        }



    }
}
