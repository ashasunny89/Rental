<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rental;


class SuitPiece extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'available','price'];

    public function rentals()
    {
        return $this->belongsToMany(Rental::class)->withTimestamps();
    }

    public static function isAvailableForRental($suitPieceId, $rentalDate, $returnDate)
    {
        // Initialize an empty array to store rental dates
        $rentalDates = [];

        // Retrieve existing rentals for the given suit piece and date range
        $existingRentals = Rental::whereHas('suitPieces', function ($query) use ($suitPieceId) {
            $query->where('suit_piece_id', $suitPieceId);
        })->where(function ($query) use ($rentalDate, $returnDate) {
            $query->whereBetween('rental_date', [$rentalDate, $returnDate])
                ->orWhereBetween('return_date', [$rentalDate, $returnDate])
                ->orWhere(function ($query) use ($rentalDate, $returnDate) {
                    $query->where('rental_date', '<', $rentalDate)
                        ->where('return_date', '>', $returnDate);
                });
        })->get();

        // Iterate over existing rentals and add rental dates to the array
        foreach ($existingRentals as $rental) {
            $rentalDates[] = [
                'rental_date' => $rental->rental_date,
                'return_date' => $rental->return_date
            ];
        }

        // Check if the suit piece is available
            $isAvailable = $existingRentals->isEmpty();

            // Return availability status and rental dates
            return [
                'available' => $isAvailable,
                'rental_dates' => $rentalDates
            ];
    }

    public function getBookedRentalDates($rentalDate, $returnDate)
    {
        // Retrieve booked rental dates for the suit piece
        $bookedDates = Rental::whereHas('suitPieces', function ($query) {
            $query->where('suit_piece_id', $this->id);
        })->where(function ($query) use ($rentalDate, $returnDate) {
            $query->whereBetween('rental_date', [$rentalDate, $returnDate])
                ->orWhereBetween('return_date', [$rentalDate, $returnDate])
                ->orWhere(function ($query) use ($rentalDate, $returnDate) {
                    $query->where('rental_date', '<', $rentalDate)
                        ->where('return_date', '>', $returnDate);
                });
        })->pluck('rental_date', 'return_date');

        return $bookedDates;
    }

}
