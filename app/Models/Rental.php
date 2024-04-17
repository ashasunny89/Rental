<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_address',
        'phone1',
        'phone2',
        'rental_date',
        'return_date',
        'advanced_amount',
        'total_rent',
        'total_amount',
        'discount',
    ];

    public function suitPieces()
    {
        return $this->belongsToMany(SuitPiece::class)->withPivot('price');
    }

    
}
