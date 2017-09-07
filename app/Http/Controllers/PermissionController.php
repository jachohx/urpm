<?php
namespace App\Http\Controllers;

use App\Models\Model;
use Illuminate\Http\Request;
use Input, Exception, Response;
use App\Models\Permission;
use App\Models\Menu;
use App\Models\Role;
use Auth;
use App\Utils\ConfigUtils;

class PermissionController extends RestfulBaseController
{

    protected $modelName = 'App\Models\Permission';
    protected $errorMsg = [
        'name.required'                 => '权限标识必填',
        'name.unique'                   => '权限标识已存在',
        'display_name.required'         => '权限名称必填',
        'display_name.max'              => '权限名称最多255个字符',
        'description.required'          => '权限描述必填',
        'description.max'               => '权限描述最多255个字符',
    ];
    public function __construct()
    {
        parent::__construct();
        $this->storeValidateRule = [
            'name'                      => 'required|unique:' . config('admin.permission_table'),
            'display_name'              => "required|max:255",
            'description'               => 'required|max:255',
        ];
        $this->updateValidateRule = [
            'display_name'              => "required|max:255",
            'description'               => 'required|max:255'
        ];
    }

    public function index()
    {
        $permissions = Permission::query();
        $inputs = Input::all();
        foreach ($inputs as $inputKey => $inputValue) {
            if ($inputValue !== '' && $inputKey != 'page' && $inputKey != 'perPage') {
                $permissions = $permissions->where($inputKey, 'LIKE', '%' . $inputValue . '%');
            }
        }
        $pager = $permissions->orderBy('id', 'DESC')->paginate();
        return view('admin.permission.list', compact('pager'));
    }

    public function show()
    {
        $roles = Role::all();
        $menus = Menu::toTree();
        return view('admin.permission.item', compact('roles' ,'menus'));
    }

    public function edit($id)
    {
        $permission = new Permission();
        $item = $permission->find($id);
        $roles = Role::all();
        $menus = Menu::toTree();
        return view('admin.permission.item', compact('item', 'roles' ,'menus'));
    }

    protected function _updateModel(Model $permission, Array $inputs, $type)
    {
        if (ConfigUtils::inConfigIds($permission->id, "admin.permission_table_cannot_manage_ids", false))
            return $this->retError(403, '该权限禁止修改!');
        $opInfo = ($type == 1 ? '增加权限。' : '修改权限。');
        $permission->name = Input::get('name');
        $permission->display_name = Input::get('display_name');
        $permission->description = Input::get('description', '');
        $permission->controllers = Input::get('controllers');
        if (!$permission->save()) {
            return $this->retJson(503, '操作出错!');
        }
        $id = $permission->id;
        //role
        $roles = Input::get('roles');
        if (!empty($roles)) {
            foreach ($roles as $k => $role) {
                if (empty($role)) unset($roles[$k]);
            }
        }
        $permission->saveRoles($roles);
        //menu
        $menu =  Input::get('menus');
        $menus = [];
        if ($menu == 0) {
            $menus = [];
        } else {
            $menus[] = $menu;
        }
        $permission->saveMenus($menus);
        return $this->retJson(200, '操作成功!');
    }

    public function destroy($id)
    {
        if (ConfigUtils::inConfigIds($id, "admin.permission_table_cannot_manage_ids", false))
            return $this->retError(403, '该权限禁止修改!');
        $permission = new Permission();
        $permission->id = $id;
        $permission->exists = true;
        if (!$permission->delete()) {
            return $this->retJson(503, '操作出错!');
        }
        $permission->saveRoles([]);
        $permission->saveMenus([]);
        $this->appOpLog("删除数据ID:$id", $permission->getAttributes());
        return $this->retJson(200, '操作成功!');
    }

}