<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'wards';
}
