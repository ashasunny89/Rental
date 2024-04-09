<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        // if (auth()->admin()->id == 1) {
        //     return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        // }

        Auth::user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function userpassword(Request $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }
        $where["id"]=$request->id;
        // $where["password"]=Hash::make($request->password);

        $data=User::where($where)->get();
        if($data)
        {
            $update['password']=Hash::make($request->password);
            $data=User::where($where)->update($update);
            return back()->withPasswordStatus(__('Password successfully updated.'));

        }
        else{
            return back()->withPasswordStatus(__('Current password incorrect.'));

        }
        

    }

    public function add(request $data)
    {
        if(auth()->user()->role=='admin')
        {
            $role='press';
        }
        else if(auth()->user()->role=='press')
        {
            $role='head';

        }
        else if(auth()->user()->role=='head')
        {
            $role='branch';
        }
        if($data->check)
        {
            $check=$data->check;
        }
        else{
            $check='NO';
        }

         User::create([
            'name' => $data->name,
            'email' => $data->email,
            'is_admin'=>'1',
            'role'=>$role,
            'password' => Hash::make($data->password),
            'phone' => $data->phone,
            'status' => 1,
            'created_by' => auth()->user()->id,
            'check_required'=>$check,
        ]);
        return back()->withdStatus(__('Profile successfully Created.'));
    }

    public function userupdate(request $data)
    {
        $val['name']= $data->name;
        $val['phone'] = $data->phone;
         User::where("id",$data->id)->update($val);
        return back()->withStatus(__('Profile successfully updated.'));
    }
}
