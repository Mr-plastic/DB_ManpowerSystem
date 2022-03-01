<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\executive;
use App\Models\cared_family;
use App\Models\carers;
use App\Models\care_station;
use App\Models\users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExecutiveController extends Controller
{
        //行政人員功能
        public function show_executive(){
            $id = Auth::id();
            $user = users::where('id','=',$id)->get();
            if($user[0]['Authority']=='super user'){
                $Authority = 'super user';
            }else{
                $Authority = 'general user';
            }
            $data = executive::where('資料狀態','=','正常')->get();
            $datas = executive::orderBy('資料狀態','asc')->orderBy('created_at','desc')->get();
            $count_executive = 0;
            $sum_age = 0;
            $average_age = 0;
            //Get the current UNIX timestamp.
            $now = time();
    
            $sum_salary = 0;
            $average_salary = 0;
    
            $administrative_one = 0;
            $administrative_two = 0;
            $administrative_three = 0;
            
            $business_one = 0;
            $business_two = 0;
            $business_three = 0;
    
            foreach($data as $key => $value){
                $dob = strtotime($value->生日); //生日to時間
                $difference = $now - $dob;
                $age = floor($difference / 31556926);
                $sum_age = $sum_age + $age;
                $count_executive = $count_executive + 1;
    
                //平均薪資
                $sum_salary = $sum_salary + $value->薪資;
    
                //職等分級
                if($value->職等 == '行政一級'){
                    $administrative_one = $administrative_one + 1;
                }
                if($value->職等 == '行政二級'){
                    $administrative_two = $administrative_two + 1;
                }
                if($value->職等 == '行政三級'){
                    $administrative_three = $administrative_three + 1;
                }
                if($value->職等 == '業務一級'){
                    $business_one = $business_one + 1;
                }
                if($value->職等 == '業務二級'){
                    $business_two = $business_two + 1;
                }
                if($value->職等 == '業務三級'){
                    $business_three = $business_three + 1;
                }
            }
            if($count_executive == 0){
                $average_age = 0;
            }else{
                $average_age = floor($sum_age / $count_executive);
            }

            if($count_executive == 0){
                $average_salary = 0;
            }else{
                $average_salary = floor($sum_salary / $count_executive);
            }
            $year_salary_sum = $sum_salary * 12;
            return view('executive',[
                                        'Authority' => $Authority,
                                        'count_executive' => $count_executive,
                                        'average_age' => $average_age,
                                        'average_salary' => $average_salary,
                                        'administrative_one' => $administrative_one,
                                        'administrative_two' => $administrative_two,
                                        'administrative_three' => $administrative_three,
                                        'business_one' => $business_one,
                                        'business_two' => $business_two,
                                        'business_three' => $business_three,
                                        'sum_salary' => $sum_salary,
                                        'year_salary_sum' => $year_salary_sum,
                                        'datas' => $datas,
                                        'data_length' => count($datas)+1,
                                        'user' => $user
                                        ]);
        }
    //新增executive
    public function add_executive(Request $request){
        $time=Carbon::now()->toDateTimeString();
        $executive_exist = executive::where('身分證字號','=',$request->id)->count();
        if($executive_exist > 0){
            return response()->json('行政人員已存在，請使用編輯模式!');
        }
        executive::insert(
            [
                '身分證字號' => $request->id,
                '姓名' => $request->name,
                '職等' => $request->select_status,
                '負責區域' => $request->select_area,
                '薪資' => $request->salary,
                '電話'=> $request->phone,
                '性別'=> $request->sex,
                '生日'=> $request->birth,
                '開始任職日期'=>$request->start_date,
                '住址'=>$request->address,
                '照片路徑'=>$request->img_base64,
                '資料狀態'=>'正常',
                'created_at'=>$time,
                'updated_at'=>$time
             ]
        );
        return response()->json($request);
    }

    //info executive
    public function info_executive(Request $request){
        $data = executive::where('身分證字號', '=', $request->id)->get();
        return response()->json([$data]);
    }

    //show edit executive
    public function show_edit_executive(Request $request){
        $data = executive::where('身分證字號', '=', $request->id)->get();
        return response()->json([$data]);
    }

    //save edit executive
    public function save_edit_executive(Request $request){
        executive::where('身分證字號','=',$request->initial_id)
                ->update([
                    '身分證字號' => $request->id,
                    '姓名' => $request->name,
                    '職等' => $request->select_status,
                    '負責區域' => $request->select_area,
                    '薪資' => $request->salary,
                    '電話'=> $request->phone,
                    '性別'=> $request->sex,
                    '生日'=> $request->birth,
                    '開始任職日期'=>$request->start_date,
                    '住址'=>$request->address,
                    '照片路徑'=>$request->img_base64,
                    '資料狀態'=>$request->select,
                ]);
        return response()->json($request);
    }

    //show search executive
    public function show_search_executive(Request $request){
        $data = executive::where('身分證字號', '=', $request->search_id)->get();
        return response()->json([$data]);
    }
}
