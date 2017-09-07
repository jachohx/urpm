<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Input, Auth, Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Model;
use App\Utils\ConfigUtils;

class UserController extends RestfulBaseController
{
    protected $modelName = 'App\Models\User';
    protected $errorMsg = [
        'username.required'             => '用户名必填',
        'username.unique'               => '用户名已存在',
        'email.required'                => '邮箱必填',
        'email.email'                   => '邮箱格式不正确',
        'email.unique'                  => '邮箱已存在',
        'password.required'             => '密码必填',
        'password.confirmed'            => '两次密码不一致',
        'password.min'                  => '密码最小6位数',
        'mobile.digits'                 => '手机号码为11位数',
        'roles.array'                   => '权限错误',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->storeValidateRule = [
            'username'                      => 'required|unique:' . config('admin.user_table'),
            'email'                         => "required|email|unique:" . config('admin.user_table'),
            'password'                      => 'required|confirmed|min:6',
            'mobile'                        => 'digits:11',
            'roles'                         => 'array',
        ];
        $this->updateValidateRule = [
            'password'                      => 'confirmed|min:6',
            'mobile'                        => 'digits:11',
            'roles'                         => 'array',
        ];
    }

    public function index()
    {
        $users = User::query();
        $inputs = Input::all();
        foreach ($inputs as $inputKey => $inputValue) {
            if ($inputValue !== '' && $inputKey != 'page' && $inputKey != 'perPage') {
                $users = $users->where($inputKey, 'LIKE', '%' . $inputValue . '%');
            }
        }
        $pager = $users->orderBy('id', 'DESC')->paginate();
        return view('admin.user.list', compact('pager'));
    }

    public function show()
    {
        $roles = Role::all();
        return view('admin.user.item', compact('roles'));
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = new User();
        $item = $user->find($id);
        return view('admin.user.item', compact('roles', 'item'));
    }


    protected function _updateModel(Model $user, Array $inputs, $type)
    {
        if (ConfigUtils::inConfigIds($user->id, "admin.user_table_cannot_manage_ids", false))
            return $this->retError(403, '该用户禁止修改!');
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = bcrypt(Input::get('password', ''));
        $user->mobile = Input::get('mobile', '');
        $user->sex = Input::get('sex', 1);
        if (!$user->save()) {
            return $this->retJson(503, '操作出错!');
        }
        $roles = Input::get('roles');
        if (!empty($roles)) {
            foreach ($roles as $k => $role) {
                if (empty($role)) unset($roles[$k]);
            }
        }
        $user->saveRoles($roles);
        return $this->retJson(200, '操作成功!');
    }

    public function destroy($id)
    {
        if (ConfigUtils::inConfigIds($id, "admin.user_table_cannot_manage_ids", false))
            return $this->retError(403, '该用户禁止修改!');
        $user = new User();
        $user->id = $id;
        $user->exists = true;
        if (!$user->delete()) {
            return $this->retJson(503, '操作出错!');
        }
        $this->appOpLog("更新数据ID:$id", $user->getAttributes());
        return $this->retJson(200, '操作成功!');
    }

}
