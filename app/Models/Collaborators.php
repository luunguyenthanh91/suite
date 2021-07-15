<?php

namespace App\Models;
use App\Models\BankCollaborators;
use Illuminate\Database\Eloquent\Model;

class Collaborators extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'collaborators';

    public function bank()
    {
        return $this->hasMany(BankCollaborators::class, 'collaborators_id' , 'id');
    }
}
