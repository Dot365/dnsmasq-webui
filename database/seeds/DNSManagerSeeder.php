<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;

class DNSManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'DNS Manager',
            'slug' => 'dns',
        ]);

        $permission = Permission::create([
            'name'        => 'DNS management',
            'slug'        => 'dns.management',
            'http_method' => '',
            'http_path'   => "/domains\r\n/records",
        ]);
        $role->permissions()->save($permission);

        $permission = Permission::create([
            'name'        => 'Configure management',
            'slug'        => 'config.management',
            'http_method' => '',
            'http_path'   => "/configures",
        ]);
        $role->permissions()->save($permission);

        $menu = Menu::create([
            'parent_id' => 0,
            'title'     => 'DNS',
            'icon'      => 'fa-server',
            'uri'       => '',
        ]);
        $menu->order = $menu->id;
        $menu->save();

        Menu::insert([
            [
                'parent_id' => $menu->id,
                'order'     => $menu->id + 1,
                'title'     => 'Domain',
                'icon'      => 'fa-globe',
                'uri'       => '/domains',
            ],
            [
                'parent_id' => $menu->id,
                'order'     => $menu->id + 2,
                'title'     => 'Record',
                'icon'      => 'fa-sitemap',
                'uri'       => '/records',
            ],
            [
                'parent_id' => 0,
                'order'     => $menu->id + 3,
                'title'     => 'Configure',
                'icon'      => 'fa-cog',
                'uri'       => '/configures',
            ],
        ]);
    }
}
