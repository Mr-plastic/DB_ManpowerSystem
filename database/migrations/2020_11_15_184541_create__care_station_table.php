<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('care_station');
        Schema::create('care_station', function (Blueprint $table) {
            $table->string('照護人員ID',10)->unique();
            $table->string('派駐家庭代碼',8);
            $table->primary(['照護人員ID','派駐家庭代碼']);
            $table->string('照護人員姓名',20);
            $table->foreign(['照護人員ID','照護人員姓名'])
                  ->references(['照護人員ID','照護人員姓名'])->on('carers')
                  ->onUpdate('cascade');
            $table->string('受照護者姓名',20);
          $table->foreign(['派駐家庭代碼','受照護者姓名'])
                  ->references(['家庭代碼','受照護者姓名'])->on('cared_family')
                  ->onUpdate('cascade');
            $table->date('派駐開始日期');
            $table->date('派駐結束日期');
            $table->char('派駐狀態')->default('派駐中');
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
        Schema::dropIfExists('care_station');
    }
}
