<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Directory;
use App\Models\Committe;

class DirectoryController extends Controller
{
    public function ShowDirectory()
    {
        $committees = Committe::all(); // Fetch all committees from the database
    
        return view('pages.directory.directory-add', compact('committees'));
    }

    public function AddDirectory(Request $request)
    {
        // Validation rules
        $request->validate([
            'positionname' => 'required',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust based on your requirements
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'priority' => 'required', // Adjust based on your requirements
            'committe' => 'required|exists:committes,committe', // Validate committe existence
        ]);
    
        // Get the uploaded file
        $image = $request->file('image');
    
        // Generate a unique name for the file
        $imageName = time() . '.' . $image->getClientOriginalExtension();
    
        // Move the uploaded file to the public/uploads directory
        $image->move(public_path('uploads'), $imageName);
    
        // Fetch committe_id based on committe name
        $committe = Committe::where('committe', $request->input('committe'))->first();

        if (!$committe) {
            // Handle the case where the committe does not exist
            return response()->json(['error' => 'Committe not found'], 404);
        }

        // Create a new Directory instance and save to the database
        $directory = new Directory;
        $directory->positionname = $request->input('positionname');
        $directory->name = $request->input('name');
        $directory->image = 'uploads/' . $imageName;
        $directory->address = $request->input('address');
        $directory->phone = $request->input('phone');
        $directory->email = $request->input('email');
        $directory->priority = $request->input('priority');
        $directory->committe_id = $committe->id; // Use the fetched committe_id
        $directory->save();
    
        // Return a JSON response with the newly created directory details
        return redirect()->route('directory')->with('success', 'Directory entry added successfully');    }
    
    

    public function ListDirectory(Request $request)
    {
        $directory = DB::table('directories')->get();
        return view('pages.directory.directory-list', compact('directory'));
    }

    public function EditDirectory($id)
    {
        $directory = DB::table('directories')->where('id',$id)->get();
        return view('pages.directory.directory-edit', compact('directory'));
    }

    public function updatedirectory(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'positionname' => 'required',
            'name' => 'required',
            'image' => 'image', // Allow empty image for updating
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
    
        // Find the Directory by ID
        $directory = Directory::findOrFail($id);
    
        // Update the Directory fields
        $directory->positionname = $request->input('positionname');
        $directory->name = $request->input('name');
        $directory->address = $request->input('address');
        $directory->phone = $request->input('phone');
        $directory->email = $request->input('email');
    
        // Check if a new image file is provided
        if ($request->hasFile('image')) {
            // Handle image upload
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
    
            // Update the image path
            $directory->image = 'uploads/' . $imageName;
        }
    
        // Save the updated Directory
        $directory->save();
    
        // Redirect with success message
        return redirect()->route('directory-list')->with('success', 'Directory entry updated successfully');
    }

    public function DeleteDirectory($id)
    {
        DB::table('directories')->where('id', $id)->delete();
        return back()->with('success','successfully deleted');
    }

    //*******************/ Commitee ********************//

    public function ShowCommitee()
    {
        return view('pages.directory.add-commitee');
    }

    public function AddCommitte(Request $request)
    {
        // Validation rules
        $request->validate([
            'committe' => 'required',
        ]);
    
        // Create a new Directory instance and save to the database
        $committes = new Committe;
        $committes->committe = $request->input('committe');
        $committes->save();
    
        // Redirect with success message
        return redirect()->route('commitee')->with('success', 'Directory entry added successfully');
    }

    // public function showForm()
    // {
    //     $committees = Committe::all(); // Fetch all committees from the database

    //     return view('pages.directory.directory-add', compact('committees'));
    // }
        
}
