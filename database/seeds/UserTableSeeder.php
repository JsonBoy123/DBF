<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lastid = DB::table('users')->insert([
            'name' => 'DBF_Main',
            'email' =>'dbf_main',
            'password' => Hash::make('dbf123'),
        ])->lastInsertId();

        $emp_id = DB::table('employees')->insert([
            'first_name' => 'DBF_Main',
            'last_name' =>'Shop',
            'user_id' =>$lastid,
            'status' => 0,
        ])->lastInsertId();

        DB::table('shops')->insert([
            'shop_owner_id' => 'DBF_Main',
            'last_name' =>'Shop',
            'user_id' =>$emp_id,
            'status' => 0,
        ]);

    }
}