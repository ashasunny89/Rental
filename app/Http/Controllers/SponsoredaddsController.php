<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;

class SponsoredaddsController extends Controller
{
    public function ShowAds()
    {
        return view('pages.sponsoredads.sponsor-add');
    }

    public function AddSponsor(Request $request)
    {
        // Validate the form data
        $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get the uploaded file
        $image = $request->file('banner_image');

        // Generate a unique name for the file
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Move the uploaded file to the public/uploads directory
        $image->move(public_path('uploads'), $imageName);

        // Create a new banner record in the database
        Banner::create([
            'banner_title' => $request->input('banner_title'),
            'banner_image' => 'uploads/' . $imageName, // Store the path relative to the public folder
            'sponsor'=> 1
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Banner added successfully');
    }

    public function ListSponsor(Request $request)
    {
        $Sponsored = DB::table('banners')->where('sponsor', 1)->get();
        return view('pages.sponsoredads.sponsor-list', compact('Sponsored'));
    }

    public function EditSponsor($id)
    {
        $Sponsored = DB::table('banners')->where('id',$id)->get();
        return view('pages.sponsoredads.sponsor-edit', compact('Sponsored'));
    }

    // public function UpdateSponsore(Request $request, $id)
    // {
    //     // Validate the form data
    //     $request->validate([
    //         'banner_title' => 'required|string|max:255',
    //         'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    
    //     // Find the banner by ID
    //     $Sponsored = Banner::findOrFail($id);
    
    //     // Update banner title
    //     $Sponsored->banner_title = $request->input('banner_title');
    
    //     // Update banner image if a new image is provided
    //     if ($request->hasFile('banner_image')) {
    //         // Delete the existing image
    //         Storage::delete($Sponsored->banner_image);
    
    //         // Upload the new image
    //         $imagePath = $request->file('banner_image')->store('public/uploads');
    
    //         // Update the image path in the database
    //         $Sponsored->banner_image = $imagePath;
    //     }
    
    //     // Save the changes
    //     $Sponsored->save();
    
    //     // Redirect with success message
    //     return redirect()->back()->with('success', 'Banner updated successfully');
    // }

    public function UpdateSponsore(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Find the Banner by ID
        $Sponsored = Banner::findOrFail($id);
    
        // Update Banner fields
        $Sponsored->banner_title = $request->input('banner_title');
    
        // Check if a new image file is provided
        if ($request->hasFile('banner_image')) {
            // Handle image upload
            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            // Update the image path
            $Sponsored->banner_image = 'uploads/' . $imageName;
        }
    
        // Save the updated Banner
        $Sponsored->save();
    
        // Redirect with success message
        return redirect()->route('sponsor-list')->with('success', 'sponsor updated successfully');
    }

    public function DeleteSponsor($id)
    {
        DB::table('banners')->where('id', $id)->delete();
        return back()->with('success','successfully deleted');
    }
}
