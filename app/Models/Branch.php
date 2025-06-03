<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $fillable = ['name'];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function stocks()
    {
        return $this->hasManyThrough(Stock::class, Store::class);
    }
    public function getStocksCountAttribute()
    {
        return $this->stocks()->count();
    }

    public function products()
    {
        return $this->hasManyThrough(Products::class, Stock::class, 'store_id', 'id', 'id', 'product_id');
    }


}
