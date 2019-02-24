<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(\Encore\Admin\Auth\Database\AdminTablesSeeder::class);
         $this->call(DNSManagerSeeder::class);
         $this->call(ConfigureSeeder::class);
    }
}
