<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateACLOrangTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl_orang', function (Blueprint $table) {
			$table->increments('id');
			$table->string('kode');
			$table->string('nama')->nullable();
			$table->string('email')->unique();
			$table->string('password', 64);
			$table->string('telepon', 20)->nullable();
			$table->text('alamat')->nullable();
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();

			$table->index(['deleted_at', 'email']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('acl_orang');
	}
}
