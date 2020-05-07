<?php

namespace App\Models;

use App\Scopes\OfferScope;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = "offers";
    protected $fillable = ['name_ar', 'photo', 'name_en', 'price', 'details_ar', 'details_en', 'created_at', 'updated_at', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    // public $timestamps = true;

    //register global scope
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OfferScope);
    }


    ######################### local scopes ####################
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeInvalid($query)
    {
        return $query->where('status', 0)->whereNull('details_ar');
    }

    #########################################################

    //mutators

    public function setNameEnAttribute($value)
    {
        $this->attributes['name_en'] = strtoupper($value);
    }
}
