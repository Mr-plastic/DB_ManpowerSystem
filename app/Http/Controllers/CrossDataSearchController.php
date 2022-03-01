<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\care_station;
use App\Models\carers;
use App\Models\cared_family;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CrossDataSearchController extends Controller
{
    //回傳視圖
    public function crossdatasearch(){
        $id = Auth::id();
        $user = users::where('id','=',$id)->get();
        if($user[0]['Authority']=='super user'){
            $Authority = 'super user';
        }else{
            $Authority = 'general user';
        }
        $care_station = care_station::where('派駐狀態','=','派駐中')->get(); 
        $north_salary_bigger_25000 = 0;
        $west_salary_bigger_25000 = 0;
        $south_salary_bigger_25000 = 0;
        $east_salary_bigger_25000 = 0;

        $north_carers = 0;
        $west_carers = 0;
        $south_carers = 0;
        $east_carers = 0;

        $north_cared_age_sum = 0;
        $west_cared_age_sum = 0;
        $south_cared_age_sum = 0;
        $east_cared_age_sum = 0;

        $north_cared_count= 0;
        $west_cared_count = 0;
        $south_cared_count = 0;
        $east_cared_count = 0;
        foreach($care_station as $key=>$value){
            $obj = new \Carbon\Carbon($value->carers->照護人員生日);
            if(strpos($value->派駐家庭代碼,'北') !== false){ 
                if($value->carers->薪資 > 25000){
                    $north_salary_bigger_25000++;
                }
                if($obj->age > 30){
                    $cared_family_data = cared_family::where('家庭代碼','=',$value->派駐家庭代碼)
                                ->where('受照護者姓名','=',$value->受照護者姓名)
                                ->get();
                    $obj1 = new \Carbon\Carbon($cared_family_data[0]['受照護者生日']);
                    $north_cared_age_sum = $north_cared_age_sum + $obj1 -> age;
                    $north_cared_count++;
                }
                $north_carers++;
            }
            if(strpos($value->派駐家庭代碼,'中') !== false){ 
                if($value->carers->薪資 > 25000){
                    $west_salary_bigger_25000++;
                }
                if($obj->age > 30){
                    $cared_family_data = cared_family::where('家庭代碼','=',$value->派駐家庭代碼)
                                ->where('受照護者姓名','=',$value->受照護者姓名)
                                ->get();
                    $obj1 = new \Carbon\Carbon($cared_family_data[0]['受照護者生日']);
                    $west_cared_age_sum = $west_cared_age_sum + $obj1 -> age;
                    $west_cared_count++;
                }
                $west_carers++;
            }
            if(strpos($value->派駐家庭代碼,'南') !== false){ 
                if($value->carers->薪資 > 25000){
                    $south_salary_bigger_25000++;
                }
                if($obj->age > 30){
                    $cared_family_data = cared_family::where('家庭代碼','=',$value->派駐家庭代碼)
                                ->where('受照護者姓名','=',$value->受照護者姓名)
                                ->get();
                    $obj1 = new \Carbon\Carbon($cared_family_data[0]['受照護者生日']);
                    $south_cared_age_sum = $south_cared_age_sum + $obj1 -> age;
                    $south_cared_count++;
                }
                $south_carers++;
            }
            if(strpos($value->派駐家庭代碼,'東') !== false){ 
                if($value->carers->薪資 > 25000){
                    $east_salary_bigger_25000++;
                }
                if($obj->age > 30){
                    $cared_family_data = cared_family::where('家庭代碼','=',$value->派駐家庭代碼)
                                ->where('受照護者姓名','=',$value->受照護者姓名)
                                ->get();
                    $obj1 = new \Carbon\Carbon($cared_family_data[0]['受照護者生日']);
                    $east_cared_age_sum = $east_cared_age_sum + $obj1 -> age;
                    $east_cared_count++;
                }
                $east_carers++;
            }

        }

        //分母為0例外處理
        if($north_cared_count == 0){
            $average_north = 0;
        }else{
            $average_north = round($north_cared_age_sum / $north_cared_count,0);
        }

        if($west_cared_count == 0){
            $average_west = 0;
        }else{
            $average_west = round($west_cared_age_sum / $west_cared_count,0);
        }

        if($south_cared_count == 0){
            $average_south = 0;
        }else{
            $average_south = round($south_cared_age_sum / $south_cared_count,0);
        }

        if($east_cared_count == 0){
            $average_east = 0;
        }else{
            $average_east = round($east_cared_age_sum / $east_cared_count,0);
        }
        
        return view('crossdatasearch',[
            'north_salary_bigger_25000' => $north_salary_bigger_25000,
            'west_salary_bigger_25000' => $west_salary_bigger_25000,
            'south_salary_bigger_25000' => $south_salary_bigger_25000,
            'east_salary_bigger_25000' => $east_salary_bigger_25000,
            'north_carers' => $north_carers,
            'west_carers' => $west_carers,
            'south_carers' => $south_carers,
            'east_carers' => $east_carers,
            'average_north' => $average_north,
            'average_west' => $average_west,
            'average_south' => $average_south,
            'average_east' => $average_east,
            'Authority' => $Authority,
            'user' => $user
        ]);
    }
}
