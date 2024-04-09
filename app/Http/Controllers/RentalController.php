<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\SuitPiece;
use Validator;

class RentalController extends Controller
{
    /**
     * Display a listing of the rentals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rentals = Rental::all();
        return view('rental.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new rental.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suitPieces = SuitPiece::where('available',1)->get();
        return view('rental.create', compact('suitPieces'));
    }

    /**
     * Store a newly created rental in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
            'phone1' => 'required|string',
            'phone2' => 'nullable|string',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'advanced_amount' => 'required|numeric',
            'suit_piece_ids' => 'required|array',
            'suit_piece_ids.*' => 'exists:suit_pieces,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rental = Rental::create([
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'rental_date' => $request->rental_date,
            'return_date' => $request->return_date,
            'advanced_amount' => $request->advanced_amount,
        ]);

        $rental->suitPieces()->sync($request->suit_piece_ids);

        return redirect()->route('rental.index')->with('success', 'Rental created successfully.');
    }

    // Other controller methods like show, edit, update, destroy can be added here as needed.
}
