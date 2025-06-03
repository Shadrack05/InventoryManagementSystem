<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $fillable = ['name', 'quantity', 'price'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
