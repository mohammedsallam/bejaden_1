<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AstNutrbusn extends Model
{
    protected $connection;
    protected $table = 'AstNutrbusns';
    protected $primaryKey = 'ID_No';
    public $timestamps = true;
    protected $fillable = [
        'Nutr_No',
        'Name_Ar',
        'Name_En',
    ];
}
