<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\executive;
use App\Models\cared_family;
use App\Models\carers;
use App\Models\care_station;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class DbController extends Controller
{

    //受照家庭資料
    public function show_caredfamily(){
        $id = Auth::id();
        $user = users::where('id','=',$id)->get();
        if($user[0]['Authority']=='super user'){
            $Authority = 'super user';
        }else{
            $Authority = 'general user';
        }
        $datas = cared_family::orderBy('資料狀態','desc')->orderBy('created_at','desc')->get(); //回傳視圖全部人員
        $data = cared_family::orderBy('created_at', 'desc')
                            ->where('資料狀態','=','正常')->get();
        $north = 0;
        $west = 0;
        $south = 0;
        $east = 0;

        $north_male = 0;
        $north_female = 0;
        $west_male = 0;
        $west_female = 0;
        $south_male = 0;
        $south_female = 0;
        $east_male = 0;
        $east_female = 0;
        foreach($data as $key => $value){
            if(strpos($value->家庭代碼,'北') !== false){ 
                if($value->受照護者性別 == '男性'){
                    $north_male = $north_male + 1;
                }elseif($value->受照護者性別 == '女性'){
                    $north_female = $north_female + 1;
                }
                $north =$north + 1;
            }elseif(strpos($value->家庭代碼,'中') !== false){
                if($value->受照護者性別 == '男性'){
                    $west_male = $west_male + 1;
                }else{
                    $west_female = $west_female + 1;
                }
                $west =$west + 1;
            }elseif(strpos($value->家庭代碼,'南') !== false){
                if($value->受照護者性別 == '男性'){
                    $south_male = $south_male + 1;
                }else{
                    $south_female = $south_female + 1;
                }
                $south =$south + 1;
            }elseif(strpos($value->家庭代碼,'東') !== false){
                if($value->受照護者性別 == '男性'){
                    $east_male = $east_male + 1;
                }else{
                    $east_female = $east_female + 1;
                }
                $east =$east + 1;
            }
        }

        return view('caredfamily', [
                                        'north' => $north,
                                        'west' => $west,
                                        'south' => $south,
                                        'east' => $east,
                                        'north_male' => $north_male,
                                        'north_female' => $north_female,
                                        'west_male' => $west_male,
                                        'west_female' => $west_female,
                                        'south_male' => $south_male,
                                        'south_female' => $south_female,
                                        'east_male' => $east_male,
                                        'east_female' => $east_female,
                                        'datas'=>$datas,
                                        'data_length'=>count($datas)+1,
                                        'Authority' => $Authority,
                                        'user' => $user
                                          ]);
    }

    public function search_65_averageage(Request $request){
    
    $area = $request->area;
    $age_sum = 0;
    $count = 0;
    $data = cared_family::get();
    
    if($area == '台灣'){
        foreach($data as $key => $value){
            $obj = new \Carbon\Carbon($value->受照護者生日);
            if($obj->age>65){
                $age_sum = $age_sum + $obj->age;
                $count = $count + 1;
            }

        }
    }else{
        foreach($data as $key => $value){
            $obj = new \Carbon\Carbon($value->受照護者生日);
            if($obj->age>65 && strpos($value->家庭代碼,$area) !== false){
                $age_sum = $age_sum + $obj->age;
                $count = $count + 1;
            }

        }
    }
    if($count == 0){
        return response()->json('錯誤');
    }else{
        $average_age = round($age_sum/$count,0);
    }
       

    return response()->json([['average_age' =>$average_age,'count' =>$count,'area'=>$area]]);
    }
    //添加caredfamily資料
    public function add_caredfamily(Request $request){
        $family_code = $request -> family_code;
        $cared_name = $request -> cared_name;
        $sex = $request -> sex;
        $cared_birth = $request->cared_birth;
        $cared_address = $request->cared_address;
        $cared_healthy = $request->cared_healthy;
        $cared_barrier = $request->cared_barrier;
        $contact_name = $request-> contact_name; 
        $contact_phone = $request-> contact_phone; 
        $line_id = $request->line_id;
        $time=Carbon::now()->toDateTimeString();
        $cared_family_exist = cared_family::where('家庭代碼','=',$family_code)
                                            ->where('受照護者姓名','=',$cared_name)->count();
        if($cared_family_exist > 0){
            return response()->json('該家庭代碼與受照護者已存在，請使用編輯模式!');
        }
        cared_family::insert(
            ['家庭代碼' => $family_code,
             '受照護者姓名' => $cared_name,
             '受照護者性別' => $sex,
             '受照護者生日' => $cared_birth,
             '受照護者家庭住址' => $cared_address,
             '受照護者身體狀態'=> $cared_healthy,
             '障礙別'=> $cared_barrier,
             '聯絡人姓名'=> $contact_name,
             '連絡電話'=>$contact_phone,
             'Line ID'=>$line_id,
             '資料狀態'=>'正常',
             'created_at'=>$time,
             'updated_at'=>$time
             ]
        );
        


        return response()->json(['family_code'=>$family_code,
                                 'cared_name'=> $cared_name,
                                 'sex'=>$sex,
                                 'cared_birth'=>$cared_birth,
                                 'cared_address'=>$cared_address,
                                 'cared_healthy'=>$cared_healthy,
                                 'cared_barrier'=>$cared_barrier,
                                 'contact_name'=>$contact_name,
                                 'contact_phone'=>$contact_phone,
                                 'line_id'=>$line_id]);
    }
    //cared_family info
    public function info_caredfamily(Request $request){
        $data = cared_family::where('家庭代碼','=',$request->family_code)
                            ->where('受照護者姓名','=',$request->cared_name)->get();
       
        return response()->json([$data]);
    }
    //cared_family show_edit
    public function show_edit_caredfamily(Request $request){
        $data = cared_family::where('家庭代碼','=',$request->family_code)
                            ->where('受照護者姓名','=',$request->cared_name)->get();

        return response()->json([$data]);
    }
     //edit儲存變更資料
     public function save_edit_caredfamily(Request $request){
        $family_code =$request -> family_code;
        $cared_name = $request -> cared_name;
        $sex = $request -> sex;
        $cared_birth = $request->cared_birth;
        $cared_address = $request->cared_address;
        $cared_healthy = $request->cared_healthy;
        $cared_barrier = $request->cared_barrier;
        $contact_name = $request-> contact_name; 
        $contact_phone = $request-> contact_phone; 
        $line_id = $request->line_id;
        $select =$request->select;
        $time=Carbon::now()->toDateTimeString();
      
        if($select == '刪除'){
            care_station::where('派駐家庭代碼','=',$request->family_code)
                        ->where('受照護者姓名','=',$request->cared_name)
            ->update(
                [
                    '派駐狀態' => '調離原受照護家庭'
            ]);
        }
        cared_family::where('家庭代碼','=',$request->initial_family_code)
                            ->where('受照護者姓名','=',$request->initial_cared_name)
                            ->update(
                                ['家庭代碼' => $family_code,
                                '受照護者姓名' => $cared_name,
                                '受照護者性別' => $sex,
                                '受照護者生日' => $cared_birth,
                                '受照護者家庭住址' => $cared_address,
                                '受照護者身體狀態'=> $cared_healthy,
                                '障礙別'=> $cared_barrier,
                                '聯絡人姓名'=> $contact_name,
                                '連絡電話'=>$contact_phone,
                                'Line ID'=>$line_id,
                                '資料狀態'=>$select
                            ]);
        
        

        return response()->json();
    }

    //搜尋cared_family家庭代碼，姓名 ajax
    public function search_caredfamily(Request $request){
        $data = cared_family::where('家庭代碼','=',$request->search_family_code)
                            ->where('受照護者姓名','=',$request->search_cared_name)->get();
        
        return response()->json([$data]);
    }

    //search儲存變更資料
    public function save_search_caredfamily(Request $request){
        $family_code =$request -> family_code;
        $cared_name = $request -> cared_name;
        $sex = $request -> sex;
        $cared_birth = $request->cared_birth;
        $cared_address = $request->cared_address;
        $cared_healthy = $request->cared_healthy;
        $cared_barrier = $request->cared_barrier;
        $contact_name = $request-> contact_name; 
        $contact_phone = $request-> contact_phone; 
        $line_id = $request->line_id;
        $select = $request->select;
        $time=Carbon::now()->toDateTimeString();

        if($select == '刪除'){
            care_station::where('派駐家庭代碼','=',$request->family_code)
                        ->where('受照護者姓名','=',$request->cared_name)
            ->update(
                [
                    '派駐狀態' => '調離原受照護家庭'
            ]);
        }
        $data = cared_family::where('家庭代碼','=',$request->initial_family_code)
                            ->where('受照護者姓名','=',$request->initial_cared_name)
                            ->update(
                                ['家庭代碼' => $family_code,
                                '受照護者姓名' => $cared_name,
                                '受照護者性別' => $sex,
                                '受照護者生日' => $cared_birth,
                                '受照護者家庭住址' => $cared_address,
                                '受照護者身體狀態'=> $cared_healthy,
                                '障礙別'=> $cared_barrier,
                                '聯絡人姓名'=> $contact_name,
                                '連絡電話'=>$contact_phone,
                                'Line ID'=>$line_id,
                                '資料狀態'=>$select
                            ]);


        return response()->json($request);
    }
    public function show_carers(){
        return view('carers');
    }
}
