<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class InvLodhdr extends Model
{
    protected $table = 'invlodhdr';
    protected $primaryKey = 'ID_No';

    protected $fillable = ['Brn_No', 'Doc_Ty', 'Doc_No'];
}
