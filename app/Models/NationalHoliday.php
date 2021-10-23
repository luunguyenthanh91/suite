<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NationalHoliday extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'NationalHoliday';
}
