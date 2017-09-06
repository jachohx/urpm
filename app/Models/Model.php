<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as OriginModel;
use Input;

abstract class Model extends OriginModel
{
    protected $guarded = array('id');
    protected $perPage = 10;

    public function getPerPage()
    {
        $inputs = Input::all();
        return isset($inputs['perPage']) && is_numeric($inputs['perPage']) ? $inputs['perPage'] : $this->perPage;
    }

    public function isNew()
    {
        return !($this->getAttribute($this->primaryKey) > 0);
    }
}