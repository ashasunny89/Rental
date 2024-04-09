<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index');
    }

    public function edituser(Request $request)
    {
        $data=User::where('id',$request->user_id)->first();
        return view('users.EditUser',['data' => $data]);
    }
    public function userlist(User $model)
    {
        $data=User::where('created_by', auth()->user()->id)->paginate(10);
        // print_r($data);
        // die();
        return view('users.index',['data' => $data]);
    }
    public function ChangeStatus(request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'status'=>'status',
        ]);
        $order=User::where('id',$request->user_id)->first();
        if($order)
        {
            try{
                $input['status']=$request->status;
                $update=User::where('id',$request->user_id)->update($input);
                return response("Order Status Changed Successfully",200);
            }
            catch(Exception $ex){
                return response(["data"=>$ex->getMessage()],400);
            }
        }
        return response("No such order Found",200);
    }
}
