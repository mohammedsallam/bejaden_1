<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AstMarket extends Model
{

    protected $table = 'AstMarket';
    protected $primaryKey = 'ID_No';
    public $timestamps = true;
    protected $fillable = [
        'Mrkt_No',
        'Brn_No',
        'Mrkt_NmEn',
        'Mrkt_NmAr'
    ];

}
