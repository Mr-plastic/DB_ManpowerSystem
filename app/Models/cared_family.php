<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class cared_family extends Model
{
    use HasFactory;

    protected $table = 'cared_family';
    protected $fillable= ['家庭代碼', '受照護者姓名'];
    //protected $fillable = ['受照護者性別','受照護者生日','受照護者家庭住址','受照護者身體狀態','障礙別','聯絡人姓名','連絡電話','Line ID','資料狀態',];
}
