<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Rest\Response\JsonResponse;
use App\Rest\Messages\Manager;
use App\Rest\Messages\ErrorCollection;
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
        // TODO: возможно стоит перенести в service provider
        Manager::load(new ErrorCollection());

        //TODO запилить стандартные обработчики
        if(!is_numeric($request->input('id'))){
            //throw new NotFoundException();
        }

        return $next($request);
    }
}
