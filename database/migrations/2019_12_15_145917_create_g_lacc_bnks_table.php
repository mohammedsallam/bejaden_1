<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGLaccBnksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GLaccBnk', function (Blueprint $table) {
            $table->increments('ID_No');
            $table->integer('Ln_No')->nullable();//رقم السطر
            $table->bigInteger('Acc_No')->nullable();//رقم الحساب
            $table->string('Acc_NmAr', 50)->nullable();//اسم الحساب عربى
            $table->string('Acc_NmEn', 50)->nullable();//اسم الحساب انجليزى
            $table->string('Acc_Bank_No', 15)->nullable();//رقم حساب البنك
            // appearance falgs البيانات دى هتظهر معايا فى صفحات ايه؟ 1 - يظهر 0 يختفى
            // مثال: لو اخترت سند قبض نقدى يبقى البيانات هتظهر معايا فى صفحة اذافه سند قبض نقدى
            $table->boolean('RcpCsh_Voucher')->nullable();//سند قبض نقدى
            $table->boolean('RcpChk_Voucher')->nullable();//سند قبض شيك
            $table->boolean('PymCsh_voucher')->nullable();//صرف نقدى
            $table->boolean('PymChk_Voucher')->nullable();//صرف شيك
            $table->boolean('Cash_Rpt')->nullable();//مجمع النقديه
            $table->boolean('DB_Note')->nullable();//اشعار مدين
            $table->boolean('CR_Note')->nullable();//اشعار دائن
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
        Schema::dropIfExists('GLaccBnk');
    }
}
