<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class care_station extends Model
{
    use HasFactory;
    protected $table = 'care_station';
    
  #  public function cared_family(){
    #    return $this->hasOne('App\Models\cared_family', ['家庭代碼','受照護者姓名'], ['派駐家庭代碼','受照護者姓名']);
   # }

    public function carers(){
        return $this->hasOne('App\Models\carers', '照護人員ID', '照護人員ID');
    }
}
