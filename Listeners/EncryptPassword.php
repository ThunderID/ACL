<?php

namespace Thunderlabid\ACL\Listeners;

use Hash;

class EncryptPassword
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
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model = $event->data;

		if (Hash::needsRehash($model->password)) 
		{
			$model->password = Hash::make($model->password); 
		}
	}
}