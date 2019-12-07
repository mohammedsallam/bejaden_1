<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AstNutrbusn extends Model
{

    protected $table = 'AstNutrbusn';
    protected $primaryKey = 'ID_No';
    public $timestamps = true;
    protected $fillable = [
        'Nutr_No',
        'Nutr_NmAr',
        'Nutr_NmEn',
        'Short_Arb',
        'Short_Eng'
    ];

}
