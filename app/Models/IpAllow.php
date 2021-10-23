<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IpAllow extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'ipallow';

}
