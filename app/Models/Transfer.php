<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //
    protected $fillable = ['product_id', 'from_store_id', 'to_store_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function fromStore()
    {
        return $this->belongsTo(Store::class, 'from_store_id');
    }
    public function toStore()
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }
}
