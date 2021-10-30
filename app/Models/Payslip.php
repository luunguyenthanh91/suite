<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'payslip';

}
