<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function BannerShow()
    {
        return view('pages.banner.banner-add');
    }

    public function BannerStore(Request $request)
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
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Banner added successfully');
    }

    public function BannerList(Request $request)
    {
        $banners = DB::table('banners')->where('sponsor', 0)->get();
        return view('pages.banner.banner-list', compact('banners'));
    }

    public function BannerEdit($id)
    {
        $banners = DB::table('banners')->where('id',$id)->get();
        return view('pages.banner.banner-edit', compact('banners'));
    }

    public function BannerUpdate(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Find the Banner by ID
        $banner = Banner::findOrFail($id);
    
        // Update Banner fields
        $banner->banner_title = $request->input('banner_title');
    
        // Check if a new image file is provided
        if ($request->hasFile('banner_image')) {
            // Handle image upload
            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            // Update the image path
            $banner->banner_image = 'uploads/' . $imageName;
        }
    
        // Save the updated Banner
        $banner->save();
    
        // Redirect with success message
        return redirect()->route('banner-list')->with('success', 'Banner updated successfully');
    }
    
    public function BannerDelete($id)
    {
    DB::table('banners')->where('id', $id)->delete();
    return back()->with('success','successfully deleted');
    }

}
