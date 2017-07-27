<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as OriginModel;

abstract class Model extends OriginModel
{
    protected $guarded = array('id');

    public function isNew()
    {
        return !($this->getAttribute($this->primaryKey) > 0);
    }
}