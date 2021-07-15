<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPermissions extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'group_permissions';
}
