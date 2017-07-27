<?php
namespace App\Models;

use Config;
use App\Models\Interfaces\AdminRoleInterface;
use App\Models\Traits\AdminRoleTrait;
use App\Models\Model;

class Role extends Model implements AdminRoleInterface
{
    use AdminRoleTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('admin.role_table');
    }

}