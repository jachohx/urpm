<?php
namespace App\Http\Controllers;

use Input, Config;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Model;
use App\Utils\ConfigUtils;

class MenuController extends RestfulBaseController
{
    protected $modelName = 'App\Models\Menu';
    protected $validateRule = [
        'parent_id'     => 'Numeric',
        'title'         => 'required|max:50',
        'icon'          => 'required|max:50',
        'uri'           => 'max:50',
        'route_key'     => 'in:url,controller',
        'route_value'   => 'max:128',
    ];
    protected $errorMsg = [
        'title.required'                => '标题必选',
        'title.max'                     => '标题最多50个字符',
        'icon.required'                 => 'ICON必选',
        'icon.max'                      => 'ICON最多50个字符',
        'uri.max'                       => '路径最多50个字符',
        'route_key.required'            => '路由必选',
        'route_key.in'                  => '路由只能选择URL、Controller',
        'route_value.required'          => '路由内容必填',
        'route_value.max'               => '路由内容最多128个字符',
    ];
    public function index()
    {
        $menus = Menu::toTree();
        $roles = Role::all();
        return view('admin.menu.list', compact('menus', 'roles'));
    }

    public function edit($id = 0)
    {
        $menu = ($id > 0) ? Menu::findByRoleId($id) : [];
        $menus = Menu::toTree();
        $roles = Role::all();
        return view('admin.menu.item', compact('menus', 'roles', 'menu'));
    }

    protected function _updateModel(Model $menu, Array $inputs, $type)
    {
        if (ConfigUtils::inConfigIds($menu->id, "admin.menu_table_cannot_manage_ids", false))
            return $this->retError(403, '该菜单禁止修改!');
        $opInfo = ($type == 1 ? '增加菜单。' : '修改菜单。');
        if ($inputs['route_key'] == 'url' && empty($inputs['route_value'])) {
            $inputs['route_value'] = $inputs['uri'];
        }
        $menu->parent_id = $inputs['parent_id'];
        $menu->title = $inputs['title'];
        $menu->icon = $inputs['icon'];
        $menu->uri = $inputs['uri'];
        $menu->routes = $inputs['route_key'] . ":" . $inputs['route_value'];
        $roles = $inputs['roles'];
        if (!$menu->save()) {
            return $this->retJson(503, '操作出错!');
        }
        foreach ($roles as $k => $role) {
            if (empty($role)) unset($roles[$k]);
        }
        $id = $menu->id;
        $menu->saveRoles($roles);
        return $this->retJson(200, '操作成功!');
    }

    public function tree()
    {
        $inputs = Input::all();
        $serialize = $inputs['tree'];
        $tree = json_decode($serialize, true);

        Menu::saveTree($tree);
        return $this->success();
    }

    public function destroy($id)
    {
        if (ConfigUtils::inConfigIds($id, "admin.menu_table_cannot_manage_ids", false))
            return $this->retError(403, '该菜单禁止删除!');
        $menu = new Menu();
        $menu->id = $id;
        $menu->exists = true;
        if (!$menu->delete()) {
            return $this->retJson(503, '操作出错!');
        }
        $this->appOpLog("删除数据ID:$id", $menu->getAttributes());
        return $this->success();
    }
}
