<?php

namespace Thunderlabid\ACL\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\ACL\Exceptions\AppException;

///////////////
// Framework //
///////////////
use Hash;
use Carbon\Carbon;

use Thunderlabid\ACL\Models\Orang;

class GenerateKodeOrang
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
	 * @param  OrangCreated $event [description]
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model			= $event->data;
		$model->kode	= $this->generate($model);
	}

	protected function generate()
	{
		$first_letter	= Carbon::now()->format('ym').'.';
		$prev_data		= Orang::where('kode', 'like', $first_letter.'%')->orderby('kode', 'desc')->first();

		if($prev_data)
		{
			$last_letter	= explode('.', $prev_data['kode']);
			$last_letter	= ((int)$last_letter[1] * 1) + 1;
		}
		else
		{
			$last_letter	= 1;
		}

		$last_letter		= str_pad($last_letter, 4, '0', STR_PAD_LEFT);

		return $first_letter.$last_letter;
	}
}