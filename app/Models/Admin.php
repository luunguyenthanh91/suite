<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Models\Districts;
use App\Models\Provinces;
use App\Models\Wards;
use App\Models\Roles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    protected $table = 'users';

    public function districts()
    {
        return $this->hasOne(Districts::class, 'id', 'district_id');
    }
    public function provinces()
    {
        return $this->hasOne(Provinces::class, 'id', 'province_id');
    }
    public function wards()
    {
        return $this->hasOne(Wards::class, 'id', 'ward_id');
    }
    public function roles()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

}