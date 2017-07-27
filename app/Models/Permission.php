<?php
namespace App\Models;

use App\Models\Interfaces\AdminPermissionInterface;
use App\Models\Traits\AdminPermissionTrait;
use config;
use App\Models\Model;

class Permission extends Model implements AdminPermissionInterface
{
    use AdminPermissionTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('admin.permission_table');
    }

    public function roleToIds()
    {
        $roles =$this->roles;
        $ids = [];
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                if (is_object($role)) {
                    $ids[] = $role->id;
                } else if (is_array($role) && isset ($role['id'])) {
                    $ids[] = $role['id'];
                }
            }
        }
        return $ids;
    }

    public function menuToIds()
    {
        $menus = $this->menus;
        $ids = [];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                if (is_object($menu)) {
                    $ids[] = $menu->id;
                } else if (is_array($menu) && isset ($menu['id'])) {
                    $ids[] = $menu['id'];
                }
            }
        }
        return $ids;
    }

}
