<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'suit_piece_id', 'rental_date', 'return_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function suitPieces()
{
    return $this->belongsToMany(SuitPiece::class)->withTimestamps();
}
}
