<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input, Response;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Model;
use App\Utils\ConfigUtils;

class RoleController extends RestfulBaseController
{
    protected $modelName = 'App\Models\Role';
    protected $errorMsg = [
        'name.required'                 => '角色标识必填',
        'name.unique'                   => '角色标识已存在',
        'display_name.required'         => '角色名称必填',
        'display_name.max'              => '角色名称最多255个字符',
        'description.required'          => '角色描述必填',
        'description.max'               => '角色描述最多255个字符',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->storeValidateRule = [
            'name'                      => 'required|unique:' . config('admin.role_table'),
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
        $roles = Role::query();
        $inputs = Input::all();
        foreach ($inputs as $inputKey => $inputValue) {
            if ($inputValue !== '' && $inputKey != 'page' && $inputKey != 'perPage') {
                $roles = $roles->where($inputKey, 'LIKE', '%' . $inputValue . '%');
            }
        }
        $pager = $roles->orderBy('id', 'DESC')->paginate();
        return view('admin.role.list', compact('pager'));
    }

    public function show()
    {
        return view('admin.role.item');
    }

    public function edit($id)
    {
        $role = new Role();
        $item = $role->find($id);
        return view('admin.role.item', compact('item'));
    }

    protected function _updateModel(Model $role, Array $inputs, $type)
    {
        if (ConfigUtils::inConfigIds($role->id, "admin.role_table_cannot_manage_ids", false))
            return $this->retError(403, '该角色禁止修改!');
        $role->name = Input::get('name');
        $role->display_name = Input::get('display_name');
        $role->description = Input::get('description', '');
        if (!$role->save()) {
            return $this->retJson(503, '操作出错!');
        }
        return $this->retJson(200, '操作成功!');
    }

    public function destroy($id)
    {
        if (ConfigUtils::inConfigIds($id, "admin.role_table_cannot_manage_ids", false))
            return $this->retError(403, '该角色禁止修改!');
        $role = new Role();
        $role->id = $id;
        $role->exists = true;
        if (!$role->delete()) {
            return $this->retJson(503, '操作出错!');
        }
        $this->appOpLog("更新数据ID:$id", $role->getAttributes());
        return $this->retJson(200, '操作成功!');
    }

    public function permissionEdit($id)
    {
        $role = new Role();
        $role = $role->find($id);
        $pager = Permission::all();
        return view('admin.role.permission', compact('pager', 'role'));
    }

    public function permissionStore(Request $request, $id)
    {
        try {
            $role = new Role();
            $role = $role->find($id);
            $this->validate($request, [
                'perms' => 'array'
            ]);
            $role->savePermissions(Input::get('perms'));
            if (!$role->save()) {
                return $this->retJson(503, '操作出错!');
            }
            $this->appOpLog("修改权限ID:$id", $role->getAttributes());
            return $this->retJson(200, '操作成功!');
        } catch (Exception $e) {
            return $this->retJson(503, '操作出错2!');
        }
    }

}
