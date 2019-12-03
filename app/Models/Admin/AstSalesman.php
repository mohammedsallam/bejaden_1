<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AstSalesman extends Model
{

    protected $table = 'astsalesman';
    protected $primarykey = 'ID_No';
    public $timestamps = true;
    protected $fillable = [
        'Slm_No',
        'Brn_No',
        'StoreNo',
        'Slm_NmEn',
        'Slm_NmAr',
        'Target',
        'Slm_Tel',
        'Slm_Active',
        'Opn_Date',
        'Opn_Time',
        'User_ID',
        'Updt_Date'
    ];

}
