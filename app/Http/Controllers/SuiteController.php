<?php

namespace App\Http\Controllers;

use App\Models\SuitPiece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuiteController extends Controller
{
    // Display a listing of the suit pieces.
    public function index()
    {
        $suitPieces = SuitPiece::all();
        return view('suit_pieces.index', compact('suitPieces'));
    }

    // Show the form for creating a new suit piece.
    public function create()
    {
        return view('suit_pieces.create');
    }

    // Store a newly created suit piece in storage.
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'size' => 'required|string',
            'price' => 'required|integer',
            'available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SuitPiece::create($request->all());

        return redirect()->route('suit_pieces.index')->with('success', 'Suit piece created successfully.');
    }

    // Show the form for editing the specified suit piece.
    public function edit(SuitPiece $suitPiece)
    {
        return view('suit_pieces.edit', compact('suitPiece'));
    }

    // Update the specified suit piece in storage.
    public function update(Request $request, SuitPiece $suitPiece)
    { 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'size' => 'required|string',
            'price' => 'required|integer',
            'available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $suitPiece->update($request->all());

        return view('suit_pieces.edit', compact('suitPiece'))->with('success', 'Suit piece updated successfully.');
    }

    // Remove the specified suit piece from storage.
    public function destroy(SuitPiece $suitPiece)
    {
        $suitPiece->delete();

        return redirect()->route('suit_pieces.index')->with('success', 'Suit piece deleted successfully.');
    }
}
