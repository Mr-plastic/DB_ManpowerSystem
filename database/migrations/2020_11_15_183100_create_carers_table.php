<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('carers');
        Schema::create('carers', function (Blueprint $table) {
            $table->primary(['照護人員ID','照護人員姓名']);
            $table->string('照護人員ID', 10)->unique();
            $table->string('照護人員姓名', 20);
            $table->string('國籍', 16);
            $table->char('照護人員性別', 2);
            $table->decimal('薪資', 10, 0);
            $table->string('電話', 14)->default('+886');
            $table->date('照護人員生日');
            $table->date('到職日期');
            $table->date('長照人力公司合約到期日');
            $table->char('資料狀態', 3)->default('聘任中');
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
        Schema::dropIfExists('carers');
    }
}
