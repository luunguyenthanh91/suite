<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'product_types';

}
