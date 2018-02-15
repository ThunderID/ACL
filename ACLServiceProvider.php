<?php

namespace Thunderlabid\ACL;

use Illuminate\Support\ServiceProvider;
use Event;

class ACLServiceProvider extends ServiceProvider
{
	public function boot()
	{
		////////////////
		// Validation //
		////////////////
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangCreating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangUpdating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangDeleting', 'Thunderlabid\ACL\Listeners\Deleting');

		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiCreating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiUpdating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiDeleting', 'Thunderlabid\ACL\Listeners\Deleting');
		
		Event::listen('Thunderlabid\ACL\Events\Wewenang\WewenangCreating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Wewenang\WewenangUpdating', 'Thunderlabid\ACL\Listeners\Saving');
		Event::listen('Thunderlabid\ACL\Events\Wewenang\WewenangDeleting', 'Thunderlabid\ACL\Listeners\Deleting');

		//////////////////////
		// Encrypt Password //
		//////////////////////
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangCreating', 'Thunderlabid\ACL\Listeners\EncryptPassword');
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangUpdating', 'Thunderlabid\ACL\Listeners\EncryptPassword');
		
		/////////////////////////////////
		//    Assign  Kode Institusi   //
		/////////////////////////////////
		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiCreating', 'Thunderlabid\ACL\Listeners\GenerateKodeInstitusi');
		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiUpdating', 'Thunderlabid\ACL\Listeners\GenerateKodeInstitusi');

		/////////////////////////////
		//    Assign  Kode Orang   //
		/////////////////////////////
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangCreating', 'Thunderlabid\ACL\Listeners\GenerateKodeOrang');
		Event::listen('Thunderlabid\ACL\Events\Orang\OrangUpdating', 'Thunderlabid\ACL\Listeners\GenerateKodeOrang');

		////////////////////////////////
		//    Auto  Assign Wewenang   //
		////////////////////////////////
		Event::listen('Thunderlabid\ACL\Events\Institusi\InstitusiCreated', 'Thunderlabid\ACL\Listeners\AutoAssignWewenang');

	}

	public function register()
	{
		
	}
}