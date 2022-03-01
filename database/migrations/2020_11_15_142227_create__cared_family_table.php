<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaredFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cared_family', function (Blueprint $table) {
            $table->string('家庭代碼' , 8);
            $table->string('受照護者姓名' , 20);
            $table->primary(['家庭代碼','受照護者姓名']);
            $table->char('受照護者性別', 2);
            $table->date('受照護者生日');
            $table->string('受照護者家庭住址', 40);
            $table->string('受照護者身體狀態', 4000);
            $table->string('障礙別', 14);
            $table->string('聯絡人姓名', 20);
            $table->string('連絡電話', 20)->default('+886');
            $table->string('Line ID', 20);
            $table->char('資料狀態', 2)->default('正常');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cared_family');
    }
}
