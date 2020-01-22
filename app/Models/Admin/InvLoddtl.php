<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class InvLoddtl extends Model
{
    protected $table = 'invloddtl';
    protected $primaryKey = 'ID_No';

    protected $fillable = ['Brn_No', 'Doc_Ty', 'Doc_No'];
}
