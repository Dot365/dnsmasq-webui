<?php

use Illuminate\Database\Seeder;

class ConfigureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Configure::truncate();
        \App\Models\Configure::create([
            'name' => 'nameserver',
            'content' => json_encode([
                '223.5.5.5',
                '223.6.6.6',
            ])
        ]);
    }
}
