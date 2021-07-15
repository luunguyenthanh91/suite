<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'suppliers';

}
