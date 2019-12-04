<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $connection;
    public function __construct(){
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $str .= "\n";
        $keyPosition = strpos($str, 'DB_CONNECTION=');
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
        $str_arr = explode("=", $oldLine);
        // dd($str_arr);
        // dd(\App\database::where('id',1)->first()->name);
        $this->connection = $str_arr[1];
    }
    protected $table = 'countries';
    protected $fillable =[
        'country_name_ar',
        'country_name_en',
        'mob',
        'code',
        'logo'
    ];


    public function cities(){
        return $this->hasMany('App\city','id','country_id');
    }

}
