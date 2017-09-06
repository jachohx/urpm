<?php
namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogController extends BaseController
{
    public function index(Request $request)
    {
        return $this->show($request);
    }

    public function show(Request $request)
    {
        $sql = LoginLog::with('user.roles');
        if(true == $request->has('startTime')) {
            $sql->where('created_at', '>=', $request->get('startTime'));
        }
        if(true == $request->has('endTime')) {
            $sql->where('created_at', '<=', $request->get('endTime'));
        }
        $pager = $sql->orderBy('id', 'DESC')->paginate();
        return view('admin.loginLog.list', compact('pager'));
    }

}
