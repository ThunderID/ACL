<?php

namespace Thunderlabid\ACL\Middlewares;

use Illuminate\Http\Request;
use Closure, Auth, AppException;
use Carbon\Carbon;

use Thunderlabid\ACL\Models\Wewenang;

class ScopeMiddleware
{
	public function handle($request, Closure $next, $scope)
	{
		$hari_ini 	= Carbon::now();
		
		$active_u	= Auth::user();
		$active_p 	= Wewenang::where('kode_institusi', session()->get('thunder.active_kode_institusi'))->where('orang_id', $active_u['id'])->active($hari_ini)->first();

		if(!$active_p)
		{
			return redirect()->back()->withErrors(["kode_institusi" => "Anda tidak memiliki wewenang untuk data/proses ini!"]);
		}

		$scopes 	= explode('|', $scope);

		foreach ($scopes as $k => $v) {
			if(str_is('*.*', $v)){

				$flag 		= true;
				$v_scope 	= explode('.', $v);
				foreach ($v_scope as $k2 => $v2) {
					if(!in_array($v2, $active_p['scopes']))
					{
						$flag 	= false;
					}
				}

				if($flag){
					return $next($request);
				}
			}elseif(in_array($v, $active_p['scopes'])){
				return $next($request);
			}
		}

		return redirect()->back()->withErrors(["kode_institusi" => "Anda tidak memiliki wewenang untuk data/proses ini!"]);
	}

	public static function check($scope)
	{
		$hari_ini 	= Carbon::now();
		
		$active_u	= Auth::user();
		$active_p 	= Wewenang::where('kode_institusi', session()->get('thunder.active_kode_institusi'))->where('orang_id', $active_u['id'])->active($hari_ini)->first();

		if(!$active_p)
		{
			throw new AppException(["kode_institusi" => "Anda tidak memiliki wewenang untuk data/proses ini!"], 1);
		}

		$scopes 	= explode('|', $scope);
		foreach ($scopes as $k => $v) {
			if(str_is('*.*', $v)){

				$flag 		= true;
				$v_scope 	= explode('.', $v);
				foreach ($v_scope as $k2 => $v2) {
					if(!in_array($v2, $active_p['scopes']))
					{
						$flag 	= false;
					}
				}

				if($flag){
					return true;
				}
			}elseif(in_array($v, $active_p['scopes'])){
				return true;
			}
		}

		throw new AppException(["kode_institusi" => "Anda tidak memiliki wewenang untuk data/proses ini!"], 1);
	}
}