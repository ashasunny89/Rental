<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'mobile1', 'mobile2'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
