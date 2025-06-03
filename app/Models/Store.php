<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $fillable = ['name', 'branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function getStocksCountAttribute()
    {
        return $this->stocks()->count();
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'stocks')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

}
