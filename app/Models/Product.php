<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
      protected $fillable = [
        'name', 'price', 'fixedstockprice','productcode_supplier','deliverytime','description','barcode','unlimitedstock','weight','length','width','height','country_of_origin','hs_code','active','idfulfilment_customer','minimum_purchase_quantity','purchase_in_quantities_of',
    ];

 protected $hidden = [
        'password',
    ];

}
