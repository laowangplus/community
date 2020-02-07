<?php

namespace App\Http\Middleware;

use App\Http\Service\ReadLimit;
use Closure;

class UserReadLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $article_id = $request->route()->parameter('id');
        $read = new ReadLimit();
        $read->handle($article_id);
        return $next($request);
    }
}
