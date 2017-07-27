<?php
namespace App\Http\Controllers;

use App\Models\OpLog;
use App\Utils\RequestUtils;
use Input;
use App\Models\Model;
use Illuminate\Http\Request;

abstract class RestfulBaseController extends BaseController{

    protected $modelName;
    protected $controllerName;

    protected $validateRule = [];
    protected $storeValidateRule = null;
    protected $updateValidateRule = null;

    protected $errorMsg = [];
    protected $storeErrorMsg = null;
    protected $updateErrorMsg = null;

    public function __construct()
    {
        view()->share('base_url', config("app.url"));
        view()->share('assets_url', config("app.url"));
    }

    public function store(Request $request)
    {
        $inputs = Input::all();
        $validateRule = $this->storeValidateRule != null ? $this->storeValidateRule : $this->validateRule;
        $errorMsg = $this->storeErrorMsg != null ? $this->storeErrorMsg : $this->errorMsg;
        $this->validate($request, $validateRule, $errorMsg);
        $model = new $this->modelName();
        $res = $this->_updateModel($model, $inputs, 1);
        if ($res) $this->appOpLog("增加数据ID:".$model->id, $model->getAttributes());
        return $res;
    }

    public function update(Request $request, $id)
    {
        if ($id == 0) return $this->retJson(400, 'ID出错!');
        $inputs = Input::all();
        $validateRule = $this->updateValidateRule != null ? $this->updateValidateRule : $this->validateRule;
        $errorMsg = $this->updateErrorMsg != null ? $this->updateErrorMsg : $this->errorMsg;
        $this->validate($request, $validateRule, $errorMsg);
        $model = new $this->modelName();
        $model->exists = true;
        $model->id = $id;
        $res = $this->_updateModel($model, $inputs, 2);
        if ($res) $this->appOpLog("更新数据ID:$id", $model->getAttributes());
        return $res;
    }

    protected abstract function _updateModel(Model $permission, Array $inputs, $type);

    protected function appOpLog($description, $params)
    {
        $restfulParams = RequestUtils::toRestfulParams();
        $url = $restfulParams[RequestUtils::URL];
        $controller = $restfulParams[RequestUtils::CONTROLLER];
        $className = $restfulParams[RequestUtils::CLASS_NAME];
        $classMethod = $restfulParams[RequestUtils::CLASS_METHOD];
        $method = $restfulParams[RequestUtils::METHOD];
        $realMethod = $restfulParams[RequestUtils::REAL_METHOD];
        OpLog::addOpLog($url, $controller, $className, $classMethod, $method, $realMethod, $description, $params);
    }

}