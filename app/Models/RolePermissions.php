<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'role_permissions';

}
