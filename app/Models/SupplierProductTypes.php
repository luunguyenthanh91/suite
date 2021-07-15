<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierProductTypes extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'supplier_product_types';

}
