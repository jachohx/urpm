<?php
namespace App\Http\Controllers;

use Response;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller{

    public function __construct()
    {
        view()->share('base_url', config("app.url"));
        view()->share('assets_url', config("app.url"));
    }

    protected function retJson($status=1, $msg = '', $data = [])
    {
        return Response::json(['status'=>$status, 'msg'=> $msg, 'data' => $data]);
    }

    protected function retError($status=403, $msg = '')
    {
        return new JsonResponse($msg, $status);
    }

    protected function success()
    {
        return $this->retJson(200, '操作成功!');
    }

    protected function validateError(array $error)
    {
        return new JsonResponse($error, 422);
    }
}