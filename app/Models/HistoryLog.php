<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class HistoryLog extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'historyLog';

    public function userProfile()
    {
        return $this->hasOne(Admin::class, 'id', 'userId');
    }
    
}
