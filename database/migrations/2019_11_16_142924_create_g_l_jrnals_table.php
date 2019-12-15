<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGLJrnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GLJrnal', function (Blueprint $table) {
            $table->increments('ID_No');
            $table->integer('Cmp_No')->nullable();//الشركه
            $table->integer('Brn_No')->nullable();//الفرع
            $table->integer('Jr_Ty')->nullable();//نوع القيد
            $table->bigInteger('Tr_No')->nullable();//رقم القيد
            $table->integer('Month_No')->nullable();//رقم الشهر
            $table->integer('Month_Jvno')->nullable();//رقم القيد\الشهر
            $table->integer('Doc_Type')->nullable();//نوع المستند
            $table->datetime('Tr_Dt')->nullable();//تاريخ القيد
            $table->string('Tr_DtAr')->nullable();//تاريخ القيد هجرى
            $table->string('Chq_no')->nullable();//رقم الشيك
            $table->string('Bnk_Nm')->nullable();//اسم البنك
            $table->datetime('Issue_Dt')->nullable();//تاريخ استحقاق الشيك
            $table->datetime('Due_Issue_Dt')->nullable();//تاريخ استلام الشيك
            $table->bigInteger('Acc_No')->nullable();//رقم الحساب
            $table->string('Rcpt_By')->nullable();//المستلم
            $table->string('Pymt_To')->nullable();//ادفعوا لامر
            $table->string('Pymt_By')->nullable();//منصرف لواسطة
            $table->boolean('Jv_Post')->nullable();//
            $table->boolean('Trf_Post')->nullable();//
            $table->string('User_ID')->nullable();//
            $table->string('Entr_Dt')->nullable();//
            $table->string('Entr_Time')->nullable();//
            $table->integer('Ac_Ty')->nullable();//نوع الحساب
            $table->bigInteger('TrAcc_No')->nullable();//رقم الحساب
            $table->bigInteger('Cstm_No')->nullable();//رقم العميل
            $table->bigInteger('Sup_No')->nullable();//رقم المورد
            $table->bigInteger('Emp_No')->nullable();//رقم الموظف
            $table->float('Tr_Db')->nullable();//الحركه مدين
            $table->float('Tr_Cr')->nullable();//الحركه دائن
            $table->integer('Tr_Crncy')->nullable();//العمله
            $table->integer('Tr_ExchRat')->nullable();//سعر الصرف
            $table->float('Tr_TaxVal', 50, 10)->nullable();//الضريبه
            $table->integer('Salman_No')->nullable();//مندوب المبيعات
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
        Schema::dropIfExists('GLJrnal');
    }
}
