<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\carers;
use App\Models\care_station;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarersController extends Controller
{
    //回傳carers視圖
    public function show_carers(){
        $id = Auth::id();
        $user = users::where('id','=',$id)->get();
        if($user[0]['Authority']=='super user'){
            $Authority = 'super user';
        }else{
            $Authority = 'general user';
        }
        $datas = carers::orderBy('資料狀態','asc')->orderBy('created_at','desc')->get();
        $data = carers::where('資料狀態','=','聘任中')->get();
        $count_carers = 0;
        $sum_age = 0;
        $sum_salary = 0;
        $average_age = 0;
        $average_salary = 0;
        //Get the current UNIX timestamp
        $now = time();
        $male = 0;
        $female = 0;
        foreach($data as $key => $value){
            if($value->照護人員性別 == '男性'){
                $male = $male + 1;
            }else{
                $female = $female + 1;
            }
            $dob = strtotime($value->照護人員生日); //生日to時間
            $difference = $now - $dob;
            $age = floor($difference / 31556926);
            $sum_age = $sum_age + $age;
            $sum_salary = $sum_salary +$value->薪資;
            $count_carers = $count_carers + 1;
        }
        if($count_carers == 0){
            $average_age = 0;
            $average_salary = 0;
        }else{
            $average_age = floor($sum_age / $count_carers);
             $average_salary = floor($sum_salary / $count_carers);
        }
        
       
        return view('carers',[
                                'average_age' => $average_age,
                                'average_salary' => $average_salary,
                                'male' => $male,
                                'female' => $female,
                                'datas' => $datas, 
                                'data_length'=>count($datas)+1,
                                'Authority' => $Authority,
                                'user' => $user
                            ]);
    }

    //新增carers
    public function add_carers(Request $request){
        $carers_id = $request -> carers_id;
        $carers_name = $request -> carers_name;
        $nation = $request -> nation;
        $sex = $request -> sex;
        $carers_salary = $request -> carers_salary;
        $carers_phone = $request -> carers_phone;
        $carers_birth = $request -> carers_birth;
        $carers_start_date = $request -> carers_start_date;
        $carers_end_date = $request -> carers_end_date;
        $time=Carbon::now()->toDateTimeString();
        $carers_exist = carers::where('照護人員ID','=',$carers_id)->count();
        if($carers_exist > 0){
            return response()->json('照護人員已存在，請用編輯模式!');
        }
        carers::insert(
            ['照護人員ID' => $carers_id,
             '照護人員姓名' => $carers_name,
             '國籍' => $nation,
             '照護人員性別' => $sex,
             '薪資' => $carers_salary,
             '電話'=> $carers_phone,
             '照護人員生日'=> $carers_birth,
             '到職日期'=> $carers_start_date,
             '長照人力公司合約到期日'=>$carers_end_date,
             'created_at'=>$time,
             'updated_at'=>$time
             ]
        );
        return response()->json($request);
    }

    //show carers info
    public function info_carers(Request $request){
        $data = carers::where('照護人員ID','=',$request->carersID)->get();
        return response()->json([$data]);
    }
    //show carers edit
    public function show_edit_carers(Request $request){
        $data = carers::where('照護人員ID','=',$request->carersID)->get();
        return response()->json([$data]);
    }

    //save carers edit
    public function save_edit_carers(Request $request){
        $carers_id = $request -> carers_id;
        $carers_name = $request -> carers_name;
        $nation = $request -> nation;
        $sex = $request -> sex;
        $carers_salary = $request -> carers_salary;
        $carers_phone = $request -> carers_phone;
        $carers_birth = $request -> carers_birth;
        $carers_start_date = $request -> carers_start_date;
        $carers_end_date = $request -> carers_end_date;
        $select = $request -> select;
        if($select == '離職'){
            care_station::where('照護人員ID','=',$request->initial_carers_id)
                    ->update(
                        [
                            '派駐狀態'=>$request->select
                    ]);
        }

        if($select == '聘任中'){
            care_station::where('照護人員ID','=',$carers_id)
                        ->update(
                            [
                                '派駐狀態' => '調離原受照護家庭'
                            ]
                        );
        }
        carers::where('照護人員ID','=',$request->initial_carers_id)
              ->where('照護人員姓名','=',$request->initial_carers_name)
                ->update(
                            ['照護人員ID' => $carers_id,
                            '照護人員姓名' => $carers_name,
                            '國籍' => $nation,
                            '照護人員性別' => $sex,
                            '薪資' => $carers_salary,
                            '電話'=> $carers_phone,
                            '照護人員生日'=> $carers_birth,
                            '到職日期'=> $carers_start_date,
                            '長照人力公司合約到期日'=>$carers_end_date,
                            '資料狀態'=>$select
                            ]
                         );
        return response()->json($request);
    }

    //show search carers
    public function show_search_carers(Request $request){
        $data = carers::where('照護人員ID','=',$request->carers_id)->get();
        return response()->json([$data]);
    }

    //save search carers
    public function save_search_carers(Request $request){
        $carers_id = $request -> carers_id;
        $carers_name = $request -> carers_name;
        $nation = $request -> nation;
        $sex = $request -> sex;
        $carers_salary = $request -> carers_salary;
        $carers_phone = $request -> carers_phone;
        $carers_birth = $request -> carers_birth;
        $carers_start_date = $request -> carers_start_date;
        $carers_end_date = $request -> carers_end_date;
        $select = $request -> select;
        if($select == '離職'){
            care_station::where('照護人員ID','=',$request->initial_carers_id)
                    ->update(
                        [
                            '派駐狀態'=>$request->select
                    ]);
        }
        if($select == '聘任中'){
            care_station::where('照護人員ID','=',$carers_id)
                        ->update(
                            [
                                '派駐狀態' => '調離原受照護家庭'
                            ]
                        );
        }
        carers::where('照護人員ID','=',$carers_id)
                ->update(
                            ['照護人員ID' => $carers_id,
                            '照護人員姓名' => $carers_name,
                            '國籍' => $nation,
                            '照護人員性別' => $sex,
                            '薪資' => $carers_salary,
                            '電話'=> $carers_phone,
                            '照護人員生日'=> $carers_birth,
                            '到職日期'=> $carers_start_date,
                            '長照人力公司合約到期日'=>$carers_end_date,
                            '資料狀態'=>$select
                            ]
                         );
        return response()->json($request);
    }
}
