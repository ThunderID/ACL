<?php

namespace Thunderlabid\ACL\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Validator;

////////////
// EVENTS //
////////////
use Thunderlabid\ACL\Events\Orang\OrangCreated;
use Thunderlabid\ACL\Events\Orang\OrangCreating;
use Thunderlabid\ACL\Events\Orang\OrangUpdated;
use Thunderlabid\ACL\Events\Orang\OrangUpdating;
use Thunderlabid\ACL\Events\Orang\OrangDeleted;
use Thunderlabid\ACL\Events\Orang\OrangDeleting;
use Thunderlabid\ACL\Events\Orang\OrangRestored;
use Thunderlabid\ACL\Events\Orang\OrangRestoring;

use Thunderlabid\App\Traits\AlamatTrait;

class Orang extends Authenticatable
{
	use Notifiable, SoftDeletes;
	use AlamatTrait;

	protected $table 	= 'acl_orang';
	protected $fillable = ['kode', 'nama', 'email', 'password', 'telepon', 'alamat'];
	protected $hidden 	= ['password', 'remember_token',];
	protected $dates	= ['deleted_at'];
	protected $appends	= [];
	protected $rules	= [];
	protected $errors;

	protected $dispatchesEvents = [
        'created' 	=> OrangCreated::class,
        'creating' 	=> OrangCreating::class,
        'updated' 	=> OrangUpdated::class,
        'updating' 	=> OrangUpdating::class,
        'deleted' 	=> OrangDeleted::class,
        'deleting' 	=> OrangDeleting::class,
        'restored' 	=> OrangRestored::class,
        'restoring' => OrangRestoring::class,
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
	public function scopeEmail($q, $v = null)
	{
		if (!$v) return $q;
		return $q->where('email', 'like', $v);
	}

	public function scopeNama($q, $v = null)
	{
		if (!$v) return $q;
		return $q->where('nama', 'like', str_replace('*', '%', $v));
	}

	public function scopeInactive($q){
		return $q->onlyTrashed();
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
		$rules['nama'] 			= ['required', 'string'];
		$rules['email'] 		= ['required', 'email', Rule::unique($this->table)->ignore($this->id)];
		$rules['password']		= ['min:8', 'string'];

		//////////////
		// Validate //
		//////////////
		$validator = Validator::make($this->attributes, $rules);
		if ($validator->fails())
		{
			$this->errors = $validator->messages();
			return false;
		}
		else
		{
			$this->errors = null;
			return true;
		}
	}

	public function getErrorsAttribute()
	{
		return $this->errors;
	}
}
