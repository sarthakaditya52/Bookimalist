<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data=$request->input();
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1']))
            {
                //Session::put('adminSession',$data['email']);
                return redirect('/admin/dashboard');
            }
            else
            {
                return redirect('/admin')->with('flash_message_error','Invalid username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        /*if (Session::has('adminSession')) {
            return view('admin.dashboard');
        }
        else{
            return redirect('/admin')->with('flash_message_error','Please Login First');
         }*/
        return view('admin.dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success','Logged Out Succesfully');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function check_pwd(Request $request)
    {
        $data=$request->all();
        $password=$data['current_pwd'];
        $check_pwd=User::where(['email'=>Auth::user()->email])->first();
        if (Hash::check($password,$check_pwd->password))
        {
            echo "true";die;
        }
        else{
            echo "false"; die;
        }
    }

    public function update_pwd(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data=$request->all();
            //echo "<pre>"; print_r($data); die;
            $check_pwd=User::where(['email'=>Auth::user()->email])->first();
            if (Hash::check($data['current_pwd'],$check_pwd->password))
            {
                $password=bcrypt($data['new_pwd']);
                User::where(['email'=>Auth::user()->email])->update(['password'=>$password]);
                 return redirect('/admin/settings')->with('flash_message_success','Password Updated Successfully!');
            }
            else{
                return redirect('/admin/settings')->with('flash_message_error','Incorret Current Password');
            }
        }
    }
}

