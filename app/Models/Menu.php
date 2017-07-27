<?php
namespace App\Models;

use App\Models\Interfaces\AdminMenuInterface;
use App\Models\Traits\AdminMenuTrait;
use App\Models\Model;

class Menu extends Model implements AdminMenuInterface
{
    use AdminMenuTrait;

    protected $table;

    protected $primaryKey = 'id';

    protected static $branchOrder = [];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('admin.menu_table');
    }

}
