<?php

namespace App\Models;

use App\Models\GroupPermissions;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'permissions';

    public function group()
    {
        return $this->hasOne(GroupPermissions::class, 'id', 'group_permission_id');
    }
}
