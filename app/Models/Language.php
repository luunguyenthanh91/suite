<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'language';
}
