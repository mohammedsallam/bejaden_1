<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectmfsTable extends Migration {

	public function up()
	{
		Schema::create('projectmfs', function(Blueprint $table) {
			$table->increments('ID_No');
			$table->timestamps();
			$table->integer('Cmp_No')->unsigned();
			$table->integer('Prj_No')->unsigned();
			$table->integer('Prj_Parnt');
			$table->boolean('Level_Status');
			$table->integer('Level_No');
			$table->integer('Costcntr_No');
			$table->boolean('Prj_Actv');
			$table->date('Prj_Year');
			$table->enum('Prj_Status',[0,1,2,3,4,5,6]);   //PrjStatus Enum
			$table->date('Tr_Dt');
			$table->date('Tr_DtAr');
			$table->string('Prj_NmAr');
			$table->string('Prj_NmEn', 250);
			$table->string('Prj_Refno', 20);
			$table->integer('Prj_Categ');
			$table->float('Prj_Value', 50,10);
			$table->integer('Cstm_No');
			$table->integer('Slm_No');
			$table->integer('Country_No');
			$table->integer('City_No');
			$table->integer('Area_No');
			$table->integer('Acc_DB');
            $table->integer('Acc_CR');
            $table->float('FBal_Db',50,10);
			$table->float('FBal_Cr',50,10);
			$table->float('DB11',50,10);
			$table->float('DB12',50,10);
			$table->float('DB13',50,10);
			$table->float('DB14',50,10);
			$table->float('DB15',50,10);
			$table->float('DB16',50,10);
			$table->float('DB17',50,10);
			$table->float('DB18',50,10);
			$table->float('DB20',50,10);
			$table->float('DB21',50,10);
			$table->float('DB22',50,10);
			$table->float('CR11',50,10);
			$table->float('CR12',50,10);
			$table->float('CR13',50,10);
			$table->float('CR14',50,10);
			$table->float('CR15',50,10);
			$table->float('CR16',50,10);
			$table->float('CR17',50,10);
			$table->float('CR18',50,10);
			$table->float('CR19',50,10);
			$table->float('CR20',50,10);
			$table->float('CR21',50,10);
			$table->float('CR22',50,10);
			$table->integer('Brn_No');
			$table->integer('Dlv_Stor');
			$table->float('Ordr_Value',50,10);
			$table->integer('Ordr_No');
			$table->date('Ordr_Dt');
			$table->string('Prj_Adr', 200);
			$table->string('Prj_Tel', 15);
			$table->string('Prj_Mobile', 15);
			$table->string('Prj_Mobile1', 15);
			$table->date('Nxt_Vst');
			$table->date('Mnth_Year');
			$table->string('Cntct_Prsn1');
			$table->string('Cntct_Prsn2');
			$table->string('TitL1');
			$table->string('TitL2');
			$table->string('Mobile1');
			$table->string('Mobile2');
			$table->string('Email1');
			$table->string('Email2');
			$table->date('Opn_Date');
			$table->time('Opn_Time');
			$table->integer('User_ID');
			$table->date('Updt_Date');
		});
	}

	public function down()
	{
		Schema::drop('projectmfs');
	}
}
