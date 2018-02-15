<?php

namespace Thunderlabid\ACL\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Thunderlabid\App\Traits\AlamatTrait;

use Validator;

////////////
// EVENTS //
////////////
use Thunderlabid\ACL\Events\Institusi\InstitusiCreated;
use Thunderlabid\ACL\Events\Institusi\InstitusiCreating;
use Thunderlabid\ACL\Events\Institusi\InstitusiUpdated;
use Thunderlabid\ACL\Events\Institusi\InstitusiUpdating;
use Thunderlabid\ACL\Events\Institusi\InstitusiDeleted;
use Thunderlabid\ACL\Events\Institusi\InstitusiDeleting;
use Thunderlabid\ACL\Events\Institusi\InstitusiRestored;
use Thunderlabid\ACL\Events\Institusi\InstitusiRestoring;

class Institusi extends Model
{
	use AlamatTrait;
	use SoftDeletes;

	protected $table	= 'acl_institusi';
	protected $fillable	= ['institusi_id', 'kode', 'nama', 'alamat', 'email', 'telepon', 'tipe', 'bidang'];
	protected $hidden 	= [];
	protected $appends	= [];

	protected $rules	= [];
	protected $errors;

	protected $dispatchesEvents = [
		'created' 	=> InstitusiCreated::class,
		'creating' 	=> InstitusiCreating::class,
		'updated' 	=> InstitusiUpdated::class,
		'updating' 	=> InstitusiUpdating::class,
		'deleted' 	=> InstitusiDeleted::class,
		'deleting' 	=> InstitusiDeleting::class,
		'restoring' => InstitusiRestoring::class,
		'restored' 	=> InstitusiRestored::class,
	];

	// ------------------------------------------------------------------------------------------------------------
	// CONSTRUCT
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// BOOT
	// ------------------------------------------------------------------------------------------------------------
	
	// ------------------------------------------------------------------------------------------------------------
	// RELATION
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// FUNCTION
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// SCOPE
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// MUTATOR
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// ACCESSOR
	// ------------------------------------------------------------------------------------------------------------
	public function getIsDeletableAttribute()
	{
		return true;
	}

	public function getIsSavableAttribute()
	{
		//////////////////
		// Create Rules //
		//////////////////
		$rules['kode'] 		= ['required', 'string'];
		$rules['nama']		= ['required', 'string'];
		$rules['tipe']		= ['required', 'string'];

		//////////////
		// Validate //
		//////////////
		$validator = Validator::make($this->attributes, $rules);
		if ($validator->fails())
		{
			$this->errors = $validator->messages();
			return false;
		}
		return true;
	}

	public function getErrorsAttribute()
	{
		return $this->errors;
	}
}
