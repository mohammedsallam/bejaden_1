<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnvLodhdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invlodhdr', function (Blueprint $table) {
            $table->increments('ID_No');
            $table->smallInteger('Brn_No')->nullable();
            $table->smallInteger('Doc_Ty')->nullable();
            $table->smallInteger('Doc_No')->nullable();
            $table->smallInteger('Dlv_Stor')->nullable();
            $table->date('Doc_Dt')->nullable();
            $table->string('Doc_DtAr', 20)->nullable();
            $table->date('RcvngPur_Dt')->nullable();
            $table->date('Pym_Dt')->nullable();
            $table->bigInteger('Custm_Inv')->nullable();
            $table->smallInteger('Reftyp_No')->nullable();
            $table->bigInteger('Ref_No')->nullable();
            $table->bigInteger('Ref_No2')->nullable();
            $table->smallInteger('To_BrNO')->nullable();
            $table->smallInteger('To_Store')->nullable();
            $table->smallInteger('Mrkt_No')->nullable();
            $table->smallInteger('Period_Time')->nullable();
            $table->smallInteger('Pym_No')->nullable();
            $table->smallInteger('Slm_No')->nullable();
            $table->smallInteger('City_No')->nullable();
            $table->bigInteger('Cstm_No')->nullable();
            $table->bigInteger('Sup_No')->nullable();
            $table->string('Sup_Inv', 20)->nullable();
            $table->string('SubCstm_Filno', 20)->nullable();
            $table->string('Notes', 100)->nullable();
            $table->smallInteger('Curncy_No', 100)->nullable();
            $table->boolean('Curncy_No')->nullable();
            $table->boolean('Tot_Sal')->nullable();
            $table->boolean('Tot_Pur')->nullable();
            $table->boolean('Tot_Cost')->nullable();
            $table->boolean('Tot_Disc')->nullable();
            $table->boolean('Tot_Prct')->nullable();
            $table->boolean('Tot_ODisc')->nullable();
            $table->boolean('Tot_OPrct')->nullable();
            $table->boolean('Tot_Disc2')->nullable();

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
        Schema::dropIfExists('invlodhdr');
    }
}
