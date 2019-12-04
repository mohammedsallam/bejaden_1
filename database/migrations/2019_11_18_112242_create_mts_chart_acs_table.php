<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtsChartAcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MtsChartAc', function (Blueprint $table) {
            $table->increments('ID_No');
            $table->integer('Cmp_No')->nullable()->unsigned()->index();//رقم الشركه
            // $table->foreign('Cmp_No')->references('Cmp_No')->on('MainCompany');
            $table->bigInteger('Acc_No')->nullable();//رقم الحساب
            $table->bigInteger('Parnt_Acc')->nullable();//رقم الحساب الرئيسى
            $table->enum('Acc_Typ', [1,2,3,4,5,6,7])->nullable();//نوع الحساب  - مالوش استخدام دلوقتى ENUM
            $table->integer('Level_No')->nullable();//رقم المستوى
            $table->integer('Acc_Ntr')->nullable();//طبيعة الحساب - 1 مدين - 2 دائن ENUM
            $table->boolean('Level_Status')->nullable();//حساب رئيسى - 0 رئيسى - 1 فرعى ENUM
            $table->string('Acc_NmAr')->nullable();//اسم الحساب عربى
            $table->string('Acc_NmEn')->nullable();//اسم الحساب انجليزى
            $table->integer('Clsacc_No1')->nullable();//حساب الميزانيه
            $table->integer('Clsacc_No2')->nullable();//حساب قائمة الدخل
            $table->integer('Clsacc_No3')->nullable();//حساب تشغيل
            $table->boolean('CostCntr_Flag')->nullable();//مالوش استخدام دلوقتى
            $table->bigInteger('Costcntr_No')->nullable();//مالوش استخدام دلوقتى
            $table->float('Fbal_DB')->nullable();//رصيداول المده مدين
            $table->float('Fbal_CR')->nullable();//رصيد اول المده دائن
            $table->float('DB11')->nullable();//حركة ياناير مدين
            $table->float('CR11')->nullable();//حركة يناير دائن
            $table->float('DB12')->nullable();//حركة فبراير مدين
            $table->float('CR12')->nullable();//حركة فبراير دائن
            $table->float('DB13')->nullable();//
            $table->float('CR13')->nullable();//
            $table->float('DB14')->nullable();//
            $table->float('CR14')->nullable();//
            $table->float('DB15')->nullable();//
            $table->float('CR15')->nullable();//
            $table->float('DB16')->nullable();//
            $table->float('CR16')->nullable();//
            $table->float('DB17')->nullable();//
            $table->float('CR17')->nullable();//
            $table->float('DB18')->nullable();//
            $table->float('CR18')->nullable();//
            $table->float('DB19')->nullable();//
            $table->float('CR19')->nullable();//
            $table->float('DB20')->nullable();//
            $table->float('CR20')->nullable();//
            $table->float('DB21')->nullable();//
            $table->float('CR21')->nullable();//
            $table->float('DB22')->nullable();//
            $table->float('CR22')->nullable();//
            $table->datetime('Acc_Dt')->nullable();//تاريخ انشاء الحساب
            $table->string('Acc_DtAr')->nullable();//تاريخ انشاء الحساب هجرى
            $table->boolean('Acc_Actv')->nullable()->default(1);//فاعلية الحساب - 0 غير فعال - 1 فعال
            $table->float('ComplxFbal_DB')->nullable();//حساب مجمع للحسابات الرئيسيه - مدين - مالوش استخدام دلوقتى
            $table->float('ComplxFbal_CR')->nullable();//حساب مجمع للحسابات الرئيسيه دائن - مالوش استخدام دلوقتى
            $table->integer('User_Id')->nullable();//
            $table->datetime('Updt_Time')->nullable();//
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
        Schema::dropIfExists('MtsChartAc');
    }
}
