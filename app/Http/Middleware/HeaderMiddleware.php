<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class HeaderMiddleware
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
        Validator::make(
            [
                'x-app' => $request->header('x-app'),
                'x-menu' => $request->header('x-menu'),
            ],
            [
                'x-app' => 'required',
                'x-menu' => 'required',
            ],
            [
                'required' => __('Header :attribute wajib diisi.'),
            ]
        )->validate();

        $organizations = json_decode($request->header('x-organization'), true);

        if (is_array($organizations) && count($organizations) > 0) {
            $request->headers->set(
                'x-organization',
                Arr::pluck($organizations, 'kd_organisasi')
            );
        } else {
            $request->headers->set('x-organization', []);
        }

        return $next($request);
    }
}
