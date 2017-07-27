<?php

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_menus')->delete();
        \DB::table('admin_menus')->insert(array (
            0 => 
                array (
                    'id'            => 1,
                    'parent_id'     => 0,
                    'order'         => 4,
                    'title'         => '配置管理',
                    'icon'          => 'fa-users',
                    'uri'           => '',
                    'routes'        => 'url:',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            1 =>
                array (
                    'id'            => 2,
                    'parent_id'     => 1,
                    'order'         => 5,
                    'title'         => '用户管理',
                    'icon'          => 'fa-user',
                    'uri'           => '/user',
                    'routes'        => 'url:/user',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            2 =>
                array (
                    'id'            => 3,
                    'parent_id'     => 1,
                    'order'         => 6,
                    'title'         => '角色管理',
                    'icon'          => 'fa-user-md',
                    'uri'           => '/role',
                    'routes'        => 'url:/role',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            3 =>
                array (
                    'id'            => 4,
                    'parent_id'     => 1,
                    'order'         => 7,
                    'title'         => '权限管理',
                    'icon'          => 'fa-pause',
                    'uri'           => '/permission',
                    'routes'        => 'url:/permission',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            4 =>
                array (
                    'id'            => 5,
                    'parent_id'     => 1,
                    'order'         => 8,
                    'title'         => '菜单管理',
                    'icon'          => 'fa-calendar',
                    'uri'           => '/menu',
                    'routes'        => 'url:/menu',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            5 =>
                array (
                    'id'            => 6,
                    'parent_id'     => 0,
                    'order'         => 1,
                    'title'         => '日志管理',
                    'icon'          => 'fa-file',
                    'uri'           => '',
                    'routes'        => 'url:',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            6 =>
                array (
                    'id'            => 7,
                    'parent_id'     => 6,
                    'order'         => 2,
                    'title'         => '日志列表',
                    'icon'          => 'fa-file-o',
                    'uri'           => '/log',
                    'routes'        => 'url:/log',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            7 =>
                array (
                    'id'            => 8,
                    'parent_id'     => 6,
                    'order'         => 3,
                    'title'         => '登录日志',
                    'icon'          => 'fa-eye',
                    'uri'           => '/loginLog',
                    'routes'        => 'url:/loginLog',
                    'created_at'    => date('Y-m-d H:i:s',time()),
                    'updated_at'    => date('Y-m-d H:i:s',time()),
                ),
            )
        );
    }
}