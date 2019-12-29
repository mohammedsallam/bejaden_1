<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GLjrnTrs extends Model
{
    protected $table = 'GLjrnTrs';
    protected $primaryKey = 'ID_No';
    protected $fillable = [
        'Cmp_No',
        'Brn_No',
        'Jr_Ty',
        'Tr_No',
        'Ln_No',
        'Month_No',
        'Month_Jvno',
        'Tr_Dt',
        'Tr_DtAr',
        'Ac_Ty',
        'Sysub_Account',
        'Acc_No',
        'Tr_Db',
        'Tr_Cr',
        'Dc_No',
        'Tr_Ds',
        'Tr_Ds1',
        'Clsacc_no1',
        'Clsacc_no2',
        'Costcntr_No',
        'Doc_Type',
        'GL_Post',
        'JV_Post',
        'User_ID',
        'Entr_Dt',
        'Entr_Time',
        'Acc_Type',
        'Rcpt_Value',
        'RetPur_Sal',
        'Salman_No',
    ];
}
