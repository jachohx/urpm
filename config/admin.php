<?php

return [
    //user
    'user_table'                            =>  'admin_users',
    'user_table_cannot_manage_ids'          =>  env('DB_USER_CANNOT_MANAGE_IDS', ""),

    //role
    'role'                                  => 'App\Models\Role',
    'role_table'                            => 'admin_roles',
    'role_user_table'                       => 'admin_role_user',
    'role_foreign_key'                      => 'role_id',
    'user_foreign_key'                      => 'user_id',
    'role_admin'                            => 'admin',
    'role_auth_page'                        =>  'errors.role',
    'role_table_cannot_manage_ids'          =>  env('DB_ROLE_CANNOT_MANAGE_IDS', ""),

    //permission
    'permission'                            => 'App\Models\Permission',
    'permission_table'                      => 'admin_permissions',
    'permission_role_table'                 => 'admin_permission_role',
    'permission_name'                       => 'name',
    'permission_display_name'               => 'display_name',
    'permission_controller'                 => 'controllers',
    'permission_menu_table'                 => 'admin_permission_menu',
    'permission_foreign_key'                => 'permission_id',
    'permission_table_cannot_manage_ids'    =>  env('DB_PERMISSION_CANNOT_MANAGE_IDS', ""),

    //menu
    'menu'                                  => 'App\Models\Menu',
    'menu_table'                            => 'admin_menus',
    'menu_role_table'                       => 'admin_role_menu',
    'menu_foreign_key'                      => 'menu_id',
    'menu_table_id_key'                     => 'id',
    'menu_table_parent_id_key'              => 'parent_id',
    'menu_table_cannot_manage_ids'          =>  env('DB_MENU_CANNOT_MANAGE_IDS', ""),

    'db_log'                                =>  env('DB_LOG', false),

];
