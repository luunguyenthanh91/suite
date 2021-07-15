<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorsJobs extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'collaborators_jobs';
}
