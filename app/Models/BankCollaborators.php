<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankCollaborators extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'bank_collaborators';
}
