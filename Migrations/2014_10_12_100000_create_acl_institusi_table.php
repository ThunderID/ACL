<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateACLInstitusiTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl_institusi', function (Blueprint $table) {
			$table->increments('id');
			$table->string('institusi_id')->nullable();
			$table->string('kode');
			$table->string('nama');
			$table->text('alamat')->nullable();
			$table->string('email', 20)->nullable();
			$table->string('telepon', 20)->nullable();
			$table->string('tipe')->nullable();
			$table->string('bidang')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->index(['deleted_at', 'kode_referensi']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('acl_institusi');
	}
}
