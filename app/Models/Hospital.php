<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = "hospitals";
    protected $fillable=['name','address','country_id','created_at','updated_at'];
    protected $hidden =['created_at','updated_at'];
    public $timestamps = true;

    public function doctors(){
        return $this -> hasMany('App\Models\Doctor','hospital_id','id');
    }
}
