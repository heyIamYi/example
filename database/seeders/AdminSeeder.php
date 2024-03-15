<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(base_path('database/seeders/json/admin.json')), true);
        $this->migrate($data);
    }

    public function migrate($data)
    {
        foreach($data as $item)
        {
            $item['password'] = Hash::make($item['password']);
            Admin::create($item);
        }
    }
}
