<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use Closure;

class BaseRestMiddleware
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
        //TODO запилить стандартные обработчики
        if(!is_numeric($request->input('id'))){
            //throw new NotFoundException();
        }

        return $next($request);
    }
}
