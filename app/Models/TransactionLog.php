<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'history_log';
}
