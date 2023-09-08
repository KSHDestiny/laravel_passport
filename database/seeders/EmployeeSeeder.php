<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(public_path()."/data/employees.json");
        $data = json_decode($json);
        foreach($data as $item){
            DB::table('employees')->insert([
                'name' => $item->name,
                'email' => $item->email,
                'age' => $item->age,
                'phone' => $item->phone,
                'address' => $item->address,
                'position' => $item->position,
                'created_at' => $item->created_at
            ]);
        }
    }
}
