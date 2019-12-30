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
        'User_ID',
        'Entr_Dt',
        'Entr_Time',
        'Ac_Ty',
        'Cstm_No',
        'Sup_No',
        'Emp_No',
        'Chrt_No',
        'Tr_Db',
        'Tr_Cr',
        'Tr_Crncy',
        'Tr_ExchRat',
        'Tr_TaxVal',        
        'Tot_Amunt',
        // 'Tr_Dif',
        // 'Crnt_Blnc',
        'Tr_Ds',
        'Tr_Ds1',
        'Dc_No',
    ];
}
