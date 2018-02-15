<?php

namespace Thunderlabid\ACL\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use Thunderlabid\App\Traits\TanggalTrait;

use Validator;

////////////
// EVENTS //
////////////
use Thunderlabid\ACL\Events\Wewenang\WewenangCreated;
use Thunderlabid\ACL\Events\Wewenang\WewenangCreating;
use Thunderlabid\ACL\Events\Wewenang\WewenangUpdated;
use Thunderlabid\ACL\Events\Wewenang\WewenangUpdating;
use Thunderlabid\ACL\Events\Wewenang\WewenangDeleted;
use Thunderlabid\ACL\Events\Wewenang\WewenangDeleting;
use Thunderlabid\ACL\Events\Wewenang\WewenangRestored;
use Thunderlabid\ACL\Events\Wewenang\WewenangRestoring;

class Wewenang extends Model
{
	use TanggalTrait;
	use SoftDeletes;

	protected $table	= 'acl_wewenang';
	protected $fillable	= ['kode_institusi', 'kode_orang', 'role', 'scopes', 'tanggal'];
	protected $hidden 	= [];
	protected $appends	= [];
	protected $dates	= ['tanggal'];
	protected $rules	= [];
	protected $errors;

	protected $dispatchesEvents = [
		'created' 	=> WewenangCreated::class,
		'creating' 	=> WewenangCreating::class,
		'updated' 	=> WewenangUpdated::class,
		'updating' 	=> WewenangUpdating::class,
		'deleted' 	=> WewenangDeleted::class,
		'deleting' 	=> WewenangDeleting::class,
		'restoring' => WewenangRestoring::class,
		'restored' 	=> WewenangRestored::class,
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
	/**
	 * @param array $variable
	 * @return json variable 
	 */

	public function setScopesAttribute(array $variable)
	{
		$this->attributes['scopes']			= json_encode($variable);
	}

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
		$rules['kode_institusi']	= ['required', 'string'];
		$rules['kode_orang']		= ['required', 'string'];
		$rules['scopes']			= ['required'];
		$rules['tanggal']			= ['required', 'date_format:"Y-m-d H:i:s"'];

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

	/**
	 * @param json variable 
	 * @return array $variable
	 */

	public function getScopesAttribute()
	{
		return json_decode($this->attributes['scopes'], true);
	}
}
