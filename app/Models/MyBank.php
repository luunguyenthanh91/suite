<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyBank extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'thanh_toan';
}
