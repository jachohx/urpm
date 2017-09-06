<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpLog;
use App\Models\Role;

class LogController extends BaseController
{
    public function index(Request $request)
    {
        return $this->show($request);
    }

    public function show(Request $request)
    {
        $sql = OpLog::with('user.roles');
        $sql->leftJoin(config('admin.user_table') . " as users", "users.id" , "=", "admin_op_log.user_id");
        if(true == $request->has('userName')) {
            $sql->where('users.username', 'LIKE', '%'.trim($request->get('userName')).'%');
        }
        if(true == $request->has('url')) {
            $sql->where('admin_op_log.url', 'LIKE', '%'.trim($request->get('url')).'%');
        }
        if(true == $request->has('startTime')) {
            $sql->where('admin_op_log.created_at', '>=', strtotime($request->get('startTime')));
        }
        if(true == $request->has('endTime')) {
            $sql->where('admin_op_log.created_at', '<=', strtotime($request->get('endTime'))+24*3600-1);
        }
        $sql->select('admin_op_log.*');
        $pager = $sql->orderBy('admin_op_log.created_at', 'desc')->paginate()->appends($request->all());
        return view('admin.log.list', compact('pager'));
    }

}