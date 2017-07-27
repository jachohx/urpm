<?php
namespace App\Http\Controllers;

use Admin;
use Input, App;
use Illuminate\Http\Request;
use App\Models\User;

class InfoController extends BaseController
{
    private $validateRule = [
        'password'                      => 'confirmed|min:6',
        'mobile'                        => 'digits:11',
    ];
    private $errorMsg = [
        'password.required'             => '新密码必填',
        'password.confirmed'            => '两次密码不一致',
        'password.min'                  => '新密码最小6位数',
        'mobile.digits'                 => '手机号码为11位数',
    ];

    public function index()
    {
        $item = Admin::user();
        return view('admin.info.item', ['item' => $item]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validateRule, $this->errorMsg);
        $id = Admin::userId();
        $user = User::find($id);
        //判断密码是否一致
        $oldPassword = Input::get('old_password', '');
        if (!empty($oldPassword) && !App::make('hash')->check($oldPassword , $user->password)) {
            return $this->validateError(['old_password' =>'输入的原密码不正确!']);
        }
        $password = Input::get('password', '');
        if (!empty($password)) {
            $user->password = bcrypt($password);
        }
        $user->mobile = Input::get('mobile', '');
        $user->sex = Input::get('sex', 1);
        if (!$user->save()) {
            return $this->retJson(503, '操作出错!');
        }
        return $this->retJson(200, '操作成功!');
    }

}
