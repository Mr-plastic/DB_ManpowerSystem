<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\care_station;
use App\Models\carers;
use App\Models\cared_family;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CareStationController extends Controller
{
    //回傳care station視圖
    public function show_care_station(){
        $id = Auth::id();
        $user = users::where('id','=',$id)->get();
        if($user[0]['Authority']=='super user'){
            $Authority = 'super user';
        }else{
            $Authority = 'general user';
        }
        $north = 0;
        $west = 0;
        $south = 0;
        $east = 0;

        $north_male = 0;
        $north_female = 0;
        $north_male_salary_sum = 0; 
        $north_female_salary_sum = 0; 
        $north_male_salary_average = 0; 
        $north_female_salary_average = 0; 

        $west_male = 0;
        $west_female = 0;
        $west_male_salary_sum = 0; 
        $west_female_salary_sum = 0; 
        $west_male_salary_average = 0; 
        $west_female_salary_average = 0; 

        $south_male = 0;
        $south_female = 0;
        $south_male_salary_sum = 0; 
        $south_female_salary_sum = 0; 
        $south_male_salary_average = 0; 
        $south_female_salary_average = 0; 

        $east_male = 0;
        $east_female = 0;
        $east_male_salary_sum = 0; 
        $east_female_salary_sum = 0; 
        $east_male_salary_average = 0; 
        $east_female_salary_average = 0; 

        $datas = care_station::orderBy('派駐狀態','asc')->orderBy('created_at','desc')->get(); //回傳視圖全部人員
        $data = care_station::where('派駐狀態','=','派駐中')->get(); //計算派駐薪資
        
        foreach($data as $key => $value){
            if(strpos($value->派駐家庭代碼,'北') !== false){ 
                if($value->carers->照護人員性別 == '男性'){
                    $north_male =$north_male + 1;
                    $north_male_salary_sum = $north_male_salary_sum + $value->carers->薪資; 
                }elseif($value->carers->照護人員性別 == '女性'){
                    $north_female = $north_female + 1;
                    $north_female_salary_sum = $north_female_salary_sum + $value->carers->薪資; 
                }
                $north =$north + 1;
            }elseif(strpos($value->派駐家庭代碼,'中') !== false){
                if($value->carers->照護人員性別 == '男性'){
                    $west_male = $west_male + 1;
                    $west_male_salary_sum = $west_male_salary_sum + $value->carers->薪資; 
                }else{
                    $west_female = $west_female + 1;
                    $west_female_salary_sum = $west_female_salary_sum + $value->carers->薪資; 

                }
                $west =$west + 1;
            }elseif(strpos($value->派駐家庭代碼,'南') !== false){
                if($value->carers->照護人員性別 == '男性'){
                    $south_male = $south_male + 1;
                    $south_male_salary_sum = $south_male_salary_sum + $value->carers->薪資; 
                }else{
                    $south_female = $south_female + 1;
                    $south_female_salary_sum = $south_female_salary_sum + $value->carers->薪資; 
                }
                $south =$south + 1;
            }elseif(strpos($value->派駐家庭代碼,'東') !== false){
                if($value->carers->照護人員性別 == '男性'){
                    $east_male = $east_male + 1;
                    $east_male_salary_sum = $east_male_salary_sum + $value->carers->薪資; 
                }else{
                    $east_female = $east_female + 1;
                    $east_female_salary_sum = $east_female_salary_sum + $value->carers->薪資; 
                }
                $east =$east + 1;
            }
        }
        if($north_male != 0){
            $north_male_salary_average = round($north_male_salary_sum/$north_male, 0); 
        }
        if($north_female != 0){
            $north_female_salary_average = round($north_female_salary_sum/$north_female, 0);
        }
        
        if($west_male != 0){
            $west_male_salary_average = round($west_male_salary_sum/$west_male, 0); 
        }
        if($west_female != 0){
            $west_female_salary_average = round($west_female_salary_sum/$west_female, 0); 
        }
        
        if($south_male != 0){
            $south_male_salary_average = round($south_male_salary_sum/$south_male, 0); 
        }
        if($south_female != 0){
            $south_female_salary_average = round($south_female_salary_sum/$south_female, 0); 
        }

        if($east_male != 0){
            $east_male_salary_average = round($east_male_salary_sum/$east_male, 0); 
        }
        if($east_female != 0){
            $east_female_salary_average = round($east_female_salary_sum/$east_female, 0); 
        }
        
        

        return view('carestation',[
            'north' => $north,
            'west' => $west,
            'south' => $south,
            'east' => $east,
            'north_male' => $north_male,
            'north_female' => $north_female,
            'north_male_salary_average' => $north_male_salary_average,
            'north_female_salary_average' => $north_female_salary_average,
            'west_male' => $west_male,
            'west_female' => $west_female,
            'west_male_salary_average' => $west_male_salary_average,
            'west_female_salary_average' => $west_female_salary_average,
            'south_male' => $south_male,
            'south_female' => $south_female,
            'south_male_salary_average' => $south_male_salary_average,
            'south_female_salary_average' => $south_female_salary_average,
            'east_male' => $east_male,
            'east_female' => $east_female,
            'east_male_salary_average' => $east_male_salary_average,
            'east_female_salary_average' => $east_female_salary_average,
            'datas'=>$datas,
            'data_length' => count($datas),
            'Authority' => $Authority,
            'user' => $user
                                    ]);
    }
    //新增care station資訊
    public function add_care_station(Request $request){
        $time=Carbon::now()->toDateTimeString();
        $carers_data = carers::where('照護人員ID','=',$request->carers_id)->get(); //判斷carers是否有無此人
        $cared_family_data = cared_family::where('家庭代碼','=',$request->cared_family_code) ////判斷care family是否有無此數據
                                    ->where('受照護者姓名','=',$request->cared_name)->get();
        $care_station_count = care_station::where('照護人員ID','=',$request->carers_id)
                                            ->where('派駐狀態','=','派駐中')->count();
        if(count($carers_data)<1){
            return response()->json('照護人員ID輸入錯誤，伺服器查無該筆ID!');
        }
        if(count($cared_family_data)<1){
            return response()->json('請檢查該筆派駐家庭代碼及受照護者姓名是否正確!');
        }
        if(count($carers_data)>0 && count($cared_family_data)>0 && $care_station_count==0) {
       
                care_station::insert(
                ['照護人員ID' => $request->carers_id,
                 '派駐家庭代碼' => $request->cared_family_code,
                 '照護人員姓名' => $carers_data[0]['照護人員姓名'],
                 '受照護者姓名' => $request->cared_name,
                 '派駐開始日期' => $request->start_date,
                 '派駐結束日期'=> $request->end_date,
                 'created_at'=>$time,
                 'updated_at'=>$time
                 ]
                );
            
            return response()->json('編輯成功');
        }else{
            return response()->json('該名照護人員已存在，請用編輯模式編輯該照護人員派駐資訊!');
        }
        
    }

    //show edit care station
    public function show_edit_care_station(Request $request){
        $care_station_data = care_station::where('照護人員ID','=',$request->carers_id)
                                            ->where('派駐家庭代碼','=',$request->cared_family_code)->get();
        return response()->json([$care_station_data]);
    }
    //save edit care station
    public function save_edit_care_station(Request $request){
        $cared_family_data = cared_family::where('家庭代碼','=',$request->cared_family_code) ////判斷care family是否有無此數據
                                    ->where('受照護者姓名','=',$request->cared_name)->get();
        
        if(count($cared_family_data)<1){
            return response()->json('該家庭代碼下無該名受照護者!');
        }

        if($cared_family_data[0]['資料狀態'] == '刪除'){
            return response()->json('該家庭代碼已被刪除，不允許變更!');
        }
        care_station::where('照護人員ID','=',$request->initial_carers_id)
                    ->where('派駐家庭代碼','=',$request->initial_cared_family_code)
                    ->update(
                        [
                            '派駐家庭代碼' => $request->cared_family_code,
                            '受照護者姓名' => $request->cared_name,
                            '派駐開始日期' => $request->start_date,
                            '派駐結束日期'=> $request->end_date,
                            '派駐狀態'=>$request->select
                    ]);
            
        return response()->json(['carers_id'=>$request->initial_carers_id]);
    }

    //show search care station
    public function show_search_care_station(Request $request){
        $care_station_data = care_station::where('照護人員ID','=',$request->carers_id)->get();

        return response()->json([$care_station_data]);
    }

    //save search care station
    public function save_search_care_station(Request $request){
        $cared_family_data = cared_family::where('家庭代碼','=',$request->cared_family_code) ////判斷care family是否有無此數據
                                    ->where('受照護者姓名','=',$request->cared_name)->get();
        if(count($cared_family_data)<1){
            return response()->json('該家庭代碼下無該名受照護者!');
        }

        if($cared_family_data[0]['資料狀態'] == '刪除'){
            return response()->json('該家庭代碼已被刪除，不允許變更!');
        }
        
        $data = care_station::where('照護人員ID','=',$request->initial_carers_id)
        ->update(
            [
                '派駐家庭代碼' => $request->cared_family_code,
                '受照護者姓名' => $request->cared_name,
                '派駐開始日期' => $request->start_date,
                '派駐結束日期'=> $request->end_date,
                '派駐狀態'=>$request->select
        ]);
        return response()->json($data);
    }
}
