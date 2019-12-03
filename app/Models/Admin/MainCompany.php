<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Admin;
use App\Models\Admin\MainBranch;

class MainCompany extends Model
{
    protected $table = 'MainCompany';
    protected $primaryKey = 'ID_No';
    protected $fillable = [
        'Cmp_No',
        'Cmp_NmAr',
        'Cmp_NmEn',
        'Cmp_Email',
        'Cmp_Adrs',
        'Cmp_Tel',
        'Picture',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'id', 'ID_No');
    }

    public function branches(){
        return $this->hasMany(MainBranch::class, 'Cmp_No', 'Cmp_No');
    }
}
