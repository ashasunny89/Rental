<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\block_tb;
use App\Models\payment_tb;
use App\Models\Directory;


use Validator;


class HomeController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('dashboard');
    }
    
    public function block(Request $request)
    {
       

        $res=block_tb::where('parent_id',0)->get();
        if($res)
        {
            return response($res,200);  
        }
        else{
            return response("no data found",400); 
        }

        
    }

    public function mandalam(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'block' => 'required'
        
        ]);
        if($validator->fails()){
            return response("please provide valid details",401);       
        }
        else{

              $res=block_tb::where('parent_id',$request->block)->get();
                if($res)
                {
                    return response(["data"=>$res],200);  
                }
                else{
                    return response(["data"=>"no data found"],400); 
                }

        }
    }

    public function total()
    {
      $total = DB::table('payment_tb')->sum('amount');
      return view('dashboard', compact('total'));
    }

    
}


