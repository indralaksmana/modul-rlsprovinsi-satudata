<?php namespace Satudata\Rlsprovinsi\Http\Middleware;

use Closure;

/**
 * The RlsprovinsiMiddleware class.
 *
 * @package Satudata\Rlsprovinsi
 * @author  MKI <info@mkitech.net>
 */
class RlsprovinsiMiddleware
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
        return $next($request);
    }
}
