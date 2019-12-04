<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMTScustmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MTScustmr', function (Blueprint $table) {
            $table->increments('ID_No');
            $table->integer('Cmp_No')->nullable();//
            $table->integer('Brn_No')->nullable();//
            $table->bigInteger('Cstm_No')->nullable()->unique();//
            $table->boolean('Cstm_Active')->nullable();//
            $table->integer('Cstm_Ctg')->nullable();//
            $table->string('Cstm_Refno')->nullable();//
            $table->integer('Prnt_cstm')->nullable();//
            $table->integer('Level_no')->nullable();//
            $table->boolean('Have_sub')->nullable();//
            $table->integer('Main')->nullable();//
            $table->integer('Internal_Invoice')->nullable();//
            $table->bigInteger('Acc_No')->nullable();//
            $table->bigInteger('Acc_ArAp')->nullable();//

            $table->string('Cstm_NmEn')->nullable();//
            $table->string('Cstm_NmAr')->nullable();//
            $table->string('Cstm_Adr')->nullable();//
            $table->string('Cstm_POBox')->nullable();//
            $table->string('Cstm_ZipCode')->nullable();//
            $table->string('Cstm_Rsp')->nullable();//
            $table->string('Cstm_Othr')->nullable();//
            $table->string('Cstm_Email')->nullable();//
            $table->string('Cstm_Tel')->nullable();//
            $table->string('Cstm_Fax')->nullable();//

            $table->integer('Catg_No')->nullable();//
            $table->integer('Slm_No')->nullable();//
            $table->integer('Mrkt_No')->nullable();//
            $table->integer('Nutr_No')->nullable();//
            $table->integer('Cntry_No')->nullable();//
            $table->integer('City_No')->nullable();//
            $table->integer('Area_No')->nullable();//
            $table->float('Credit_Value')->nullable();//
            $table->integer('Credit_Days')->nullable();//

            $table->integer('Cntct_Prsn1')->nullable();//
            $table->integer('Cntct_Prsn2')->nullable();//
            $table->integer('Cntct_Prsn3')->nullable();//
            $table->integer('Cntct_Prsn4')->nullable();//
            $table->integer('Cntct_Prsn5')->nullable();//
            $table->integer('TitL1')->nullable();//
            $table->integer('TitL2')->nullable();//
            $table->integer('TitL3')->nullable();//
            $table->integer('TitL4')->nullable();//
            $table->integer('TitL5')->nullable();//
            $table->integer('Mobile1')->nullable();//
            $table->integer('Mobile2')->nullable();//
            $table->integer('Mobile3')->nullable();//
            $table->integer('Mobile4')->nullable();//
            $table->integer('Mobile5')->nullable();//
            $table->integer('Email1')->nullable();//
            $table->integer('Email2')->nullable();//

            $table->float('Fbal_Db')->nullable();//
            $table->float('Fbal_CR')->nullable();//
            $table->float('CBal')->nullable();//
            $table->float('BalAgL30')->nullable();//
            $table->float('BalAgG30')->nullable();//
            $table->float('BalAgG60')->nullable();//
            $table->float('BalAgG90')->nullable();//
            $table->float('BalAgG120')->nullable();//
            $table->float('BalAgG150')->nullable();//
            $table->float('BalAgG180')->nullable();//
            $table->float('BalAgG270')->nullable();//
            $table->float('CR11')->nullable();//
            $table->float('CR12')->nullable();//
            $table->float('CR13')->nullable();//
            $table->float('CR14')->nullable();//
            $table->float('CR15')->nullable();//
            $table->float('CR16')->nullable();//
            $table->float('CR17')->nullable();//
            $table->float('CR18')->nullable();//
            $table->float('CR19')->nullable();//
            $table->float('CR20')->nullable();//
            $table->float('CR21')->nullable();//
            $table->float('CR22')->nullable();//

            $table->float('DB11')->nullable();//
            $table->float('DB12')->nullable();//
            $table->float('DB13')->nullable();//
            $table->float('DB14')->nullable();//
            $table->float('DB15')->nullable();//
            $table->float('DB16')->nullable();//
            $table->float('DB17')->nullable();//
            $table->float('DB18')->nullable();//
            $table->float('DB19')->nullable();//
            $table->float('DB20')->nullable();//
            $table->float('DB21')->nullable();//
            $table->float('DB22')->nullable();//

            $table->float('Fbal_Rcpt')->nullable();//
            $table->integer('Custmr_Scope')->nullable();//
            $table->datetime('Opn_Date')->nullable();//
            $table->datetime('Opn_Time')->nullable();//
            $table->datetime('Updt_Date')->nullable();//
            $table->integer('Cstm_Agrmnt')->nullable();//
            $table->float('Disc_prct')->nullable();//
            $table->integer('Itm_Sal')->nullable();//

            $table->float('Fbal_BalAgL30')->nullable();//
            $table->float('Fbal_BalAgG30')->nullable();//
            $table->float('Fbal_BalAgG60')->nullable();//
            $table->float('Fbal_BalAgG90')->nullable();//
            $table->float('Fbal_BalAgG120')->nullable();//
            $table->float('Fbal_BalAgG150')->nullable();//
            $table->float('Fbal_BalAgG180')->nullable();//
            $table->float('Fbal_BalAgG270')->nullable();//
            $table->bigInteger('Linv_No')->nullable();//
            $table->string('Linv_Dt')->nullable();//
            $table->float('Linv_Net')->nullable();//
            $table->bigInteger('LRcpt_No')->nullable();//
            $table->string('LRcpt_Dt')->nullable();//
            $table->float('LRcpt_Db')->nullable();//
            $table->float('Inv_Sales')->nullable();//
            $table->float('Inv_SalesRet')->nullable();//
            $table->integer('DeserveDiscounts')->nullable();//
            $table->string('Notes')->nullable();//
            $table->bigInteger('ParentAcc_No')->nullable();//
            $table->integer('AgeNotCalculate')->nullable();//
            $table->string('Tax_No')->nullable();//
            $table->integer('User_ID')->nullable();//
            
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
        Schema::dropIfExists('MTScustmr');
    }
}
