<?php

namespace App\Http\Controllers;

use App\Models\users;
use App\Models\visited;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //回傳登入介面
    public function show_login(){
        $data = visited::where('id','=',1)->get();
        $count = $data[0]['造訪次數'] + 1;
        visited::where('id','=',1)->update(
            [
                '造訪次數' => $count
            ]
            );
        return view('login',[
            'count' => $count
        ]);
    }

    //進行登入確認
    public function post_login(Request $request){
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('showexecutive');
        }else{
            return redirect('/')->with('message','帳號或密碼錯誤');
        }
    }
    //登出功能
    public function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }
    //回傳使用者設定介面
    public function setting(){
        $data = users::orderBy('Authority','desc')->get();
        $id = Auth::id();
        $user = users::where('id','=',$id)->get();
        if($user[0]['Authority']=='super user'){
            $Authority = 'super user';
            return view('usersetting',[
                'Authority' => $Authority,
                'datas' => $data,
                'data_length' => count($data)+1,
                'user' => $user
            ]);
        }else{
            return redirect()->back();
        }
    }
    //添加新用戶
    public function add_user(Request $request){
        $user_exist = users::where('username','=',$request->username)->count();
        if($user_exist>0){
            return response()->json('用戶已存在!');
        }
        users::insert([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'Authority' => $request->selection
        ]);
        return response()->json($request);
    }
    //show edit
    public function delete_user(Request $request){
        $user = users::where('username','=',$request->initial_username)->delete();
        return response()->json([$request]);
    }

}
