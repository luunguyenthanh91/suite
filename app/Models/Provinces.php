<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'provinces';
}
