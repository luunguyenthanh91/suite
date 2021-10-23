<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PO;
use App\Models\Collaborators;
use App\Models\CollaboratorsJobs;
use App\Models\CtvJobsJoin;

class Company extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'company';

    public function dateList()
    {
        return $this->hasMany(DetailCollaboratorsJobs::class, 'company_id', 'id');
    }
    public function ctvList()
    {
        return $this->hasMany(CollaboratorsJobs::class, 'jobs_id', 'id');
    }
    public function ctvSalesList()
    {
        return $this->hasMany(CtvJobsJoin::class, 'jobs_id', 'id');
    }
}
