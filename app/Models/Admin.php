<?php

namespace App\Models;

use Auth;
use App\Models\Permission;
use App\Models\Menu;

class Admin
{
    //上一级菜单ID
    protected $parentMenuId = 0;
    //当前菜单ID
    protected $MenuId = 0;

    /**
     * 是否有当前权限
     * @param $permission
     * @return mixed
     */
    public function can($permission)
    {
        return static::user()->can($permission);
    }

    /**
     * 得到当前用户
     * @return mixed
     */
    public function user()
    {
        return Auth::user();
    }

    /**
     * 得到当前用户ID
     * @return mixed
     */
    public function userId()
    {
        return Auth::user()['id'];
    }

    /**
     * 得到用户菜单列表
     * @return array
     */
    public function menus()
    {
        $user = $this->user();
        return Menu::getUserMenu($user);
    }
    /**
     * 得到用户菜单列表
     * @return array
     */
    public function allMenus()
    {
        return Menu::all();
    }

    /**
     * 得到权限列表
     * @return array
     */
    public function permissions()
    {
        return Permission::controllerPermissions();
    }

    /**
     * 是否有权限
     * @param $roles
     * @return mixed
     */
    public function hasRole($roles)
    {
        return $this->user()->hasRole($roles);
    }

    /**
     * 是否是访客
     * @return mixed
     */
    public function guest() {
        return Auth::guest();
    }

    /**
     * 设置菜单ID
     * @param $pmid 上一级菜单ID
     * @param $mid  当前菜单ID
     */
    public function setMenuId ($pmid, $mid)
    {
        $this->parentMenuId = $pmid;
        $this->MenuId = $mid;
    }

    /**
     * 得到上一级菜单ID
     * @return int
     */
    public function getParentMenuId()
    {
        return $this->parentMenuId;
    }

    /**
     * 得到当前菜单ID
     * @return int
     */
    public function getMenuId()
    {
        return $this->MenuId;
    }
}