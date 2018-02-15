<?php

namespace Thunderlabid\ACL\Listeners;

use Thunderlabid\ACL\Models\Wewenang;

use Carbon\Carbon, Config, Auth;

class AutoAssignLoggedUser
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle event
	 * @param  WewenangSaving $event [description]
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model			= $event->data;

		if(Auth::check())
		{
			$data['kode_institusi']		= $model->kode;
			$data['orang_id']			= Auth::user()['id'];
			$data['role'] 				= Config::get('acl.default_role');
			$data['scopes'] 			= Config::get('acl.default_scopes');
			$data['tanggal']			= Carbon::now();

			$penempatan		= new Wewenang;
			$penempatan->fill($data);
			$penempatan->save();
		}
	}
}