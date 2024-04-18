<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\SuitPiece;
use Validator;
use Illuminate\Support\Facades\DB;


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
        try {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'phone1' => 'required|string|max:255',
            'phone2' => 'nullable|string|max:255|different:phone1', // Ensure phone2 is different from phone1
            'rental_date' => 'required|date|after_or_equal:today', // Ensure rental_date is not in the past
            'return_date' => 'required|date|after_or_equal:rental_date',
            'advanced_amount' => 'required|numeric',
            'suit_pieces' => 'required|array', 
            'price' => 'required|array', 
            'total_rent' => 'required|numeric', // Assuming this will be calculated on the server-side
            'total_amount' => 'required|numeric', // Assuming this will be calculated on the server-side
            'discount' => 'nullable|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        // Create a new rental instance
        $rental = new Rental();
        $rental->customer_name = $request['customer_name'];
        $rental->customer_address = $request['customer_address'];
        $rental->phone1 = $request['phone1'];
        $rental->phone2 = $request['phone2'];
        $rental->rental_date = $request['rental_date'];
        $rental->return_date = $request['return_date'];
        $rental->advanced_amount = $request['advanced_amount'];
        $rental->total_rent = $request['total_rent'];
        $rental->total_amount = $request['total_amount'];
        $rental->discount = $request['discount'];

        // Save the rental details
        $rental->save();

        // Attach suit pieces to the rental
        foreach ($request['suit_pieces'] as $index => $suitPieceId) {
            $rental->suitPieces()->attach($suitPieceId, ['price' => $request['price'][$index]]);
        }
        DB::commit();
        // Redirect to a success page or return a success response
        return redirect()->route('rental.index')->with('success', 'Rental details saved successfully.');
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return redirect()->back()->with('error', 'An error occurred while saving the rental details.');
        }    
    }

    public function checkAvailability(Request $request)
    {
        // Retrieve input data
        $suitPieceId = $request->suit_piece_id;
        $rentalDate = $request->rental_date;
        $returnDate = $request->return_date;

        // Check suit piece availability
        $suitPiece = SuitPiece::find($suitPieceId);
        $isAvailable = $suitPiece->isAvailableForRental($suitPieceId,$rentalDate, $returnDate);

        // Return JSON response
        return response()->json(['data' => $isAvailable]);
    }

    public function show(Rental $rental)
    {
        // Eager load the suit pieces relation
        $rental->load('suitPieces');

        return view('rental.show', compact('rental'));
    }

    public function edit($id)
    {
        $rental = Rental::findOrFail($id);
        $suitPieces = SuitPiece::where('available', 1)->get();
        $selectedSuitPieces = $rental->suitPieces()->select('suit_pieces.id')->pluck('suit_pieces.id');
        
        return view('rental.edit', compact('rental', 'suitPieces', 'selectedSuitPieces'));
    }
    
    public function update(Request $request, $id)
{
    // Validate the form data
    $validatedData = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_address' => 'required|string',
        'phone1' => 'required|string|max:255',
        'phone2' => 'nullable|string|max:255|different:phone1', // Ensure phone2 is different from phone1
        'rental_date' => 'required|date|after_or_equal:today', // Ensure rental_date is not in the past
        'return_date' => 'required|date|after_or_equal:rental_date',
        'advanced_amount' => 'required|numeric',
        'suit_pieces' => 'required|array', 
        'price' => 'required|array', 
        'total_rent' => 'required|numeric', // Assuming this will be calculated on the server-side
        'total_amount' => 'required|numeric', // Assuming this will be calculated on the server-side
        'discount' => 'nullable|numeric',
    ]);

    // Update the rental details
    $rental = Rental::findOrFail($id);
    $rental->update($validatedData);

    // Redirect back to the rental list or a success page
    return redirect()->route('rental.index')->with('success', 'Rental details updated successfully.');
}
}

