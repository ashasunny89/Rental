<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\fine_tb;
use App\Models\payment_tb;
use App\Models\Userprofile;
use App\Models\Directory;
use App\Models\District;

use Carbon\Carbon;
use Validator;
use DB;
use Mail;


class finecontroller extends Controller
{


    public function payfine(Request $request)
    {
        $validator= validator::make($request->all(),[
            'payment_id'=>'required',
            'amount'=>'required',
            'status'=>'required',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response($errors,401);     
            }
            else{
                    $payment['phone'] = $request->user()->username;
                    $payment['status'] = $request->status;
                    $payment['amount'] = $request->amount;
                    $payment['payment_id'] = $request->payment_id;
                    $usr=Userprofile::where(['user_name'=>$request->user()->username])->first();
                   
                    $pay=payment_tb::create($payment);
                    if($request->status=='Success')
                    {
                         
                        if($usr['expiry_date']==NULL)
                        {
                            $newDateTime['expiry_date'] = Carbon::now()->addYear();
                            
                        }
                        else
                        {
                             $newDateTime['expiry_date'] = $usr['expiry_date']->addYear();
                        }
                        $usr=Userprofile::where(['user_name'=>$request->user()->username])->update($newDateTime);
                    
                    }
                     if($request->status=='Success')
                    {
                        if($pay && $usr)
                        {
                            return response (['data'=>"Payment Successfull"],200);
    
                        }
                        else{
                            return response (['data'=>"Try again later !!!"],400);
                        }
                        
                    }
                    else
                    {
                        if($pay)
                        {
                            return response (['data'=>"Payment Failed"],200);
    
                        }
                        else{
                            return response (['data'=>"Try again later !!!"],400);
                        }
                    }
                   
            }
    }
    
    public function total(Request $request)
    {
            $total=payment_tb::where('status','Success')->sum('amount');
         
            return response (['data'=>$total],200);

    }
    
    public function district_wise(Request $request)
    {

            // Original query to get total amounts for districts with payments
     $districtsQuery = Userprofile::join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
        ->select('user_profile.district', DB::raw('SUM(payment_tb.amount) as total_amount'))
        ->where('payment_tb.status', 'Success')
        ->groupBy('user_profile.district');

        // Get the result of the original query
        $districtsResult = $districtsQuery->get()->keyBy('district'); // Use district as the key for easy lookup

        // Get all districts from the districts table
        $allDistricts = DB::table('districts')->pluck('district')->toArray();

        // Initialize the final result array
        $finalResult = [];

        // Iterate over all districts
        foreach ($allDistricts as $district) {
            // Check if the district exists in the original query result
            if (isset($districtsResult[$district])) {
                // If the district exists, append it to the final result
                $finalResult[] = $districtsResult[$district];
            } else {
                // If the district doesn't exist, add it with total_amount set to 0
                $finalResult[] = (object) ['district' => $district, 'total_amount' => 0];
            }
        }

        return response(['data' => $finalResult], 200);
    }
    
    public function max_donation_user_wise(Request $request)
    {

           $results = Userprofile::join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
                    ->select('user_profile.user_name', DB::raw('MAX(user_profile.name) as name'), DB::raw('MAX(user_profile.district) as district'), DB::raw('SUM(payment_tb.amount) as total_amount'))
                    ->where('payment_tb.status', 'Success')
                    ->groupBy('user_profile.user_name')
                    ->orderBy('total_amount', 'desc')
                    ->limit(10)
                    ->get();


          
            return response (['data'=>$results],200);

    }
    
        public function max_donation_district_wise(Request $request)
    {
       $results = UserProfile::join(
                    DB::raw('(SELECT phone, SUM(amount) as total_amount FROM payment_tb WHERE status = "Success" GROUP BY phone) as payments'),
                    'user_profile.user_name',
                    '=',
                    'payments.phone'
                )
                ->select('user_profile.name', 'user_profile.user_name', 'user_profile.district', 'payments.total_amount')
                ->where('user_profile.district', $request->district)
                ->orderBy('payments.total_amount', 'desc')
                ->limit(10)
                ->get();
          
            return response (['data'=>$results],200);

    }
    public function donation(Request $request)
    {
        $validator= validator::make($request->all(),[
            'payment_id'=>'required',
            'phone'=>'required',
            'amount'=>'required',
            'status'=>'required',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response($errors,401);     
            }
            else{
                    $payment['phone'] = $request->phone;
                    $payment['status'] = $request->status;
                    $payment['amount'] = $request->amount;
                    $payment['payment_type'] = "Donation";
                    $payment['payment_id'] = $request->payment_id;
                    $pay=payment_tb::create($payment);
                   
                    
                        if($pay)
                        {
                            return response (['data'=>"Payment Updated"],200);
    
                        }
                        else{
                            return response (['data'=>"Try again later !!!"],400);
                        }
                    
                }
    }
    
     public function history(Request $request)
    {
        
         
                    $payment['phone'] = $request->user()->username;
                   
                    $pay=payment_tb::where($payment)->get();
                    if($pay)
                    {
                        return response (['data'=>$pay],200);

                    }
                    else{
                        return response (['data'=>"Try again later !!!"],400);
                    }
            
    }
    public function expiry_null(Request $request)
    {
        $validator= validator::make($request->all(),[
            'username'=>'required',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response($errors,401);                }
            else{
                    $payment['user_name'] = $request->username;
                    $val['expiry_date'] = NULL;

                   
                    $pay=Userprofile::where($payment)->update($val);
                    if($pay)
                    {
                        return response (['data'=>$pay],200);

                    }
                    else{
                        return response (['data'=>"Try again later !!!"],400);
                    }
            }
    }

    public function district(Request $request)
    {
        $district = District::get(); 
        return response (['data'=>$district],200);
    }
    
    public function id(Request $request)
    {
        $validator= validator::make($request->all(),[
            'username'=>'required',
             'id'=>'required',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response($errors,401);                }
            else{

                    $payment['user_name'] = $request->username;

                    $pay=Userprofile::where($payment)->first();
                    if($pay)
                    {
    // return response()->json(['message' => $pay['user_name']],200);
                       $file = $request->file('id');
            $email=$pay['user_name'];
                        Mail::send([], [], function ($message) use ($email,$file) {
                        $message->to($email)
                                ->subject('UNA ID')
                                ->attach($file->getRealPath(), [
                                    'as' => $file->getClientOriginalName(),
                                    'mime' => $file->getClientMimeType(),
                                ]);
    });

    return response()->json(['message' => 'Email sent successfully'],200);

                    }
                    else{
                        return response (['data'=>"Try again later !!!"],400);
                    }
            }
    }


    public function getDirectory()
    {
        $directories = Directory::join('committes', 'directories.committe_id', '=', 'committes.id')
            ->select('committes.committe as committe', 'directories.*')
            ->orderBy('directories.priority', 'asc')
            ->get();

        $formattedDirectories = [];

        foreach ($directories as $directory) {
            $formattedDirectory = [
                // 'committe_id' => $directory->committe_id,
                'committe' => $directory->committe,
                'id' => $directory->id,
                'positionname' => $directory->positionname,
                'name' => $directory->name,
                'image' => $directory->image,
                'address' => $directory->address,
                'phone' => $directory->phone,
                'email' => $directory->email,
                'priority' => $directory->priority,
                'created_at' => $directory->created_at,
                'updated_at' => $directory->updated_at,
            ];

            $formattedDirectories[] = $formattedDirectory;
        }

        return response()->json(['directory' => $formattedDirectories], 200);
    }


}


