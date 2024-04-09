<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventsController extends Controller
{
    public function addevents(Request $request)
    {
        return view('pages.event.add');
    }

    public function eventlist()
    {
        return view('pages.event.list');
    }

 //function
    public function events(Request $request)
    {
        $request->validate([
            'event'=>'required',
            'discription'=>'required',
            'date'=>'required',
        ]);
   
        $query = DB::table('events')->insert([
            'event' => $request->input('event'),
            'discription' => $request->input('discription'),
            'date' => $request->input('date'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    return back()->with('success');
    }
    public function datelist(Request $request)
    {
        $event = DB::table('events')->get();
        return response()->json(['directory' => $event], 200);
    }
    public function list(Request $request)
    {
        $event = DB::table('events')->get();
        return view('pages.event.list', compact('event'));
    }

    public function EditEvent($id)
    {
        $event = DB::table('events')->where('id',$id)->get();
        return view('pages.event.edit', compact('event'));
    }

    public function UpdateEvent(Request $request)
    {
        $update =[
            'event' => $request->event,
            'discription' => $request->discription,
            'date' => $request->date
        ];
        DB::table('events')->where('id', $request->id)->update($update);
        return redirect()->back()->with('success','successfully deleted');
    }

    public function DeleteEvent($id)
    {
       DB::table('events')->where('id', $id)->delete();
       return back()->with('success','successfully deleted');
    }

    public function home(Request $request)
    {
        $data['banner'] = DB::table('banners')->get();
        $data['sponsor'] = DB::table('banners')->get();
         $data['total']=DB::table('payment_tb')->where('status','Success')->sum('amount');
        return response(["data"=>$data],200);
    }
}
