<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = "offers";
    protected $fillable = ['name_ar', 'photo', 'name_en', 'price', 'details_ar', 'details_en', 'created_at', 'updated_at', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    // public $timestamps = true;



    ######################### local scopes ####################
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeInvalid($query)
    {
        return $query->where('status',0)->whereNull('details_ar');
    }

    #########################################################

}
