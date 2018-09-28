<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLoginMiddleware
{
	public function handle($request, Closure $next)
	{
		if (!Auth::check()) {
			return redirect(route('notAuth'));
		}

		return $next($request);
	}
}
