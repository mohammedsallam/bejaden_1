<?php

namespace App\Models\Admin;
use App\Models\Admin\AstMarket;
use Illuminate\Database\Eloquent\Model;

class AstSalesman extends Model
{

    protected $table = 'astsalesman';
    protected $primaryKey = 'ID_No';
    public $timestamps = true;
    protected $fillable = [
        'Slm_No',
        'Brn_No',
        'Mark_No',   //المشرف
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

    public function supervisor()
    {
        return $this->belongsTo('AstMarket','Mark_No', 'ID_No');
    }

}
