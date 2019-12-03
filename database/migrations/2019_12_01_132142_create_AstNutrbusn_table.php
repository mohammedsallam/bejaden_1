<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAstNutrbusnTable extends Migration {

	public function up()
	{
		Schema::create('AstNutrbusn', function(Blueprint $table) {
			$table->increments('ID_No');
			$table->timestamps();
			$table->integer('Nutr_No')->nullable();
			$table->string('Nutr_NmAr', 50)->nullable();
			$table->string('Nutr_NmEn', 50)->nullable();
			$table->string('Short_Arb', 10)->nullable();
			$table->string('Short_Eng', 10)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('AstNutrbusn');
	}
}
