<?php

namespace App\Http\Middleware;

use Closure, Auth, Response, Log, Admin;
use Illuminate\Http\JsonResponse;
use App\Utils\RequestUtils;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $restfulParams = RequestUtils::toRestfulParams();
        // 如 /role/1
        $url = $restfulParams[RequestUtils::URL];
        // 如: App\Http\Controllers\IndexController
        $controller = $restfulParams[RequestUtils::CONTROLLER];
        // 如: getIndex
        $method = $restfulParams[RequestUtils::CLASS_METHOD];
        // 如: IndexController
        $className = $restfulParams[RequestUtils::CLASS_NAME];
        // 如: GET | POST
        $requestMethod = $restfulParams[RequestUtils::REAL_METHOD];

        $auth = '';
        $menu = [];
        $permissionName = '';

        //查找权限
        $allPermissions = Admin::permissions();
        $permissionRules = [
            strtolower($controller .'@'. $method),
            strtolower($className .'@'. $method),
            strtolower($controller .'@'. $requestMethod),
            strtolower($className .'@'. $requestMethod),
            strtolower($controller),
            strtolower($className),
        ];

        //权限判断
        foreach ($permissionRules as $p) {
            if (isset($allPermissions[$p])) {
                $permission = $allPermissions[$p];
                $auth = $permission[config('admin.permission_name')];
                $permissionName = $permission[config('admin.permission_display_name')];
                break;
            }
        }
        //菜单判断
        $allMenus = Admin::allMenus();
        $urlMatchMaxLen = 0;
        foreach ($allMenus as $m) {
            $params = explode(":", $m['routes']);
            if (empty($params[0]) || empty($params[1])) continue;
            if (($params[0] == 'url' && starts_with($url, $params[1]))) {
                $len = strlen($params[1]);
                if ($len > $urlMatchMaxLen) {
                    $menu = $m;
                }
            } else if($params[0] == 'controller' && in_array(strtolower($params[1]), $permissionRules) ) {
                $menu = $m;
                break;
            }
        }

        if (!empty($menu)) {
            $pmid = isset($menu[config('admin.menu_table_parent_id_key')]) ? $menu[config('admin.menu_table_parent_id_key')] : 0;
            $mid =  isset($menu[config('admin.menu_table_id_key')]) ? $menu[config('admin.menu_table_id_key')] : 0;
            Admin::setMenuId($pmid, $mid);
        }

        //最高管理权限
        if (Admin::hasRole(config('admin.role_admin'))) {
            return $next($request);
        }

        //判断权限
        if (!empty($auth)) {
            if (!Admin::can($auth)) {
                //ajax的返回json,其它返回首页
                if ($request->ajax()) {
                    return new JsonResponse("抱歉，你没有【 {$permissionName} [{$auth}] 】的访问授权！", 403);
                } else {
                    return Response::view(config('admin.role_auth_page'), ['role' => "抱歉，该菜单 【 {$permissionName} [{$auth}] 】未授权访问！"], 403);
                }
            }
        }

        return $next($request);
    }

}
