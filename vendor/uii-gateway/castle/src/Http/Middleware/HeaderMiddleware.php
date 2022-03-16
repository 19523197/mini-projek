<?php

namespace UIIGateway\Castle\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class HeaderMiddleware
{
    public function handle($request, Closure $next)
    {
        $request = $this->preprocessRequest($request);

        return $next($request);
    }

    /**
     * Preprocess the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request
     */
    public function preprocessRequest($request)
    {
        $data = [
            'x-app' => $request->header('x-app'),
            'x-menu' => $request->header('x-menu'),
        ];

        $rules = [
            'x-app' => 'required',
            'x-menu' => 'required',
        ];

        $messages = [
            'required' => 'Header :attribute wajib diisi.',
        ];

        Validator::make($data, $rules, $messages)->validate();

        $organizations = json_decode($request->header('x-organization'), true);
        if (is_array($organizations) && count($organizations) > 0) {
            $organizations = Arr::pluck($organizations, 'kd_organisasi');

            $request->headers->set('x-organization', implode(';', $organizations));
        } else {
            $request->headers->set('x-organization', '');
        }

        return $request;
    }
}
