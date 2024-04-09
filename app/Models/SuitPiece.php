<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuitPiece extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'available','price'];

    public function rentals()
    {
        return $this->belongsToMany(Rental::class)->withTimestamps();
    }
}
