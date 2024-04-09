<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Link;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Linkcontroller extends Controller
{
    public function LinkShow()
    {
        return view('pages.meetlink');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);
        

        $query = DB::table('links')->insert([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'start_datetime' => $request->input('start_datetime'),
            'end_datetime' => $request->input('end_datetime'),
            'created_at' => now(),
            'updated_at' => now(),                          
        ]);

        return redirect()->route('link')->with('success', 'Inserted successfully');
    }

    public function weblink(Request $request)
    {
        $links = Link::where('end_datetime', '>', Carbon::now())->get(); 
        return response (['data'=>$links],200);
    }


}
