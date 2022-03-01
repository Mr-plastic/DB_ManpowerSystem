<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executive', function (Blueprint $table) {
            $table->primary('身分證字號');
            $table->string('身分證字號',10);
            $table->string('姓名',20); 
            $table->string('職等',8);
            $table->string('負責區域',6);
            $table->decimal('薪資',10,0);
            $table->string('電話',14)->default('+');
            $table->char('性別',2);
            $table->date('生日');
            $table->date('開始任職日期');
            $table->string('住址', 40);
            $table->text('照片路徑',50000);
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
        Schema::dropIfExists('executive');
    }
}
