<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\Nurse;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Health;
use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;



class logincontroller extends Controller
{
   
    public function citizenprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [

           
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'blood_group' => 'required',
            'district' => 'required',
            'membership' => 'required',
            'dob' => 'required'
        
        ]);
        if($validator->fails()){
              $errors = $validator->errors();
                return response($errors,401);    
        }
        else{

                $input['name'] = $request->name;
                $input['address'] = $request->address;
                $input['email'] = $request->email;
                $input['whatsapp'] = $request->whatsapp;
                $input['blood_group'] = $request->blood_group;
                $input['membership'] = $request->membership;
                $input['dob'] = $request->dob;
                $input['district'] = $request->district;
            if($request->file('photo'))
            {
             $uniqid = Str::random(9);
             $fileName = $uniqid.time().'.'.$request->file('photo')->extension(); 
             $file1 = $request->file('photo')->storeAs('profile', $fileName, 'uploads');
             $input['photo']='public/app/public/'.$file1;
            }
               
                $rest=Userprofile::where(['user_name'=>$request->user()->username])->update($input);
               
               
                if($rest)
                {
                    return response(["message"=>"Profile details updated Successfully"],200);  
                }
                else{
                    return response(["message"=>"no change in data"],200); 
                }

        }
    }
    public function getprofile(Request $request)
    {
        $res=Userprofile::where(['user_name'=>$request->user()->username])->first();
        //$res1=User::where(['id'=>$res['u_id']])->first();
        if($res)
        {
            return response(["data"=>$res],200);
        }
        else{
            return response(["data"=>"no data found"],400);
        }
    }

    public function userlogin(Request $request)
    {
        
          $validator= validator::make($request->all(),[
            'phone'=>'required',
            'password'=>'required',
            'device_token'=>'required',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response($errors,401);     
            }
            else{
        
                    if (Auth::attempt(['username' => $request->phone, 'password' => $request->password])) {
                        $auth = Auth::user(); 
                        $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
                        $data['user_id'] =$auth->id;
                        $success['user_id'] =$auth->id;
                        $input['remember_token']=$request->device_token;
                        $msg['profile']=Userprofile::where('u_id',$auth->id)->first();
                       
                        $msg1=Auth::user()->update($input);
                        $msg['message']="user loggedin!!!";
                        $msg['token']= $success['token'];
                        // return response($msg,200);
                        return response()->json($msg, 200, ['Content-Type' => 'application/json;charset=UTF-8',
                            'Charset' => 'utf-8']);
                    } 
                    else{
                        $input['username']=$request->phone;
                        $input['password']=bcrypt($request->password); 
                        $input['remember_token']=$request->device_token;
                        $input['role']=$request->type;
                        $data=User::create($input);
                        $data['token'] =  $data->createToken('LaravelSanctumAuth')->plainTextToken; 
                        $usr['u_id']=$data->id;
                        $usr['phone_number']=$request->phone;
                        $usr['user_name']=$request->phone;
                        $data1=Userprofile::create($usr);
                        $msg['profile']=$data1;

                       
                        $data['message']="user created";
                        // return response($msg,200);
                        return response()->json($data, 200, ['Content-Type' => 'application/json;charset=UTF-8',
                        'Charset' => 'utf-8']);
                    }
                }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password'=>'required',
        ]);
   
        if($validator->fails()){
            return response("please provide valid details",401);       
        }
        else{

            try{
                $input['username'] = $request->username;
               
                $usr=User::where('username',$input['username'])->first();
                // return response($usr,200);
                if($usr)
                {
                    return response("username already exists",200);
                }
                $input['name'] = $request->name;
                $input['password'] = Hash::make($request->password);
                $input['username'] = $request->username;
                
                $user = User::create($input);
                // User::create($request->getAttributes())->sendEmailVerificationNotification();

              
                $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
                $success['id']=$user->id;
                
                // event(new Registered($user));
                return response(['token'=>$success['token'],"message"=>"Registered Successfully..."],200);
        
            }
            catch(Exception $ex)
            {
                return response($ex->getMessage(),400);
            }
        }
    }

}
