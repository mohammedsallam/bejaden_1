<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GLJrnal extends Model
{
    protected $table = 'GLJrnal';
    protected $primaryKey = 'ID_No';
    protected $fillable = [
        'Cmp_No',
        'Brn_No',
        'Jr_Ty',
        'Tr_No',
        'Month_No',
        'Month_Jvno',
        'Doc_Type',
        'Tr_Dt',
        'Tr_DtAr',
        'Chq_no',
        'Bnk_Nm',
        'Issue_Dt',
        'Due_Issue_Dt',
        'Acc_No',
        'Rcpt_By',
        'Pymt_To',
        'Pymt_By',
        'Jv_Post',
        'Trf_Post',
        'User_ID',
        'Entr_Dt',
        'Entr_Time',
        'Ac_Ty',
        'TrAcc_No',
        'Cstm_No',
        'Sup_No',
        'Emp_No',
        'Tr_Db',
        'Tr_Cr',
    ];
}
