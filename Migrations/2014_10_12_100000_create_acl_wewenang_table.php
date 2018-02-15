<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateACLWewenangTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl_wewenang', function (Blueprint $table) {
			$table->increments('id');
			$table->string('kode_institusi');
			$table->string('kode_orang');
			$table->string('role');
			$table->text('scopes');
			$table->datetime('tanggal');
			$table->timestamps();
			$table->softDeletes();

            $table->index(['deleted_at', 'kode_institusi', 'kode_orang']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('acl_wewenang');
	}
}
