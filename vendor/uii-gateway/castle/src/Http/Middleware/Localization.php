<?php

namespace UIIGateway\Castle\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $locale = $this->getLocale($request);

        $this->validateLocale($locale);

        if (! is_null($locale)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Get locale if available.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     *
     * @throws \Exception
     */
    protected function getLocale($request)
    {
        $locale = $request->header('x-language');
        $locale = mb_strtolower(blank($locale) ? env('APP_LOCALE', 'id') : $locale);

        $langDir = resource_path('lang');
        $availableLangs = ['en'];

        if (File::isDirectory($langDir)) {
            $availableLangs = collect(File::directories($langDir))->map(fn ($dir) => basename($dir))
                ->merge($availableLangs)
                ->toArray();
        }

        if (in_array($locale, $availableLangs)) {
            return $locale;
        }

        return null;
    }

    protected function validateLocale(&$locale)
    {
        if (is_null($locale)) {
            Log::error('Language is not available.');

            return;
        }

        // detect valid locale via Carbon translations.
        // we assume, if locale isn't available in Carbon, it means the locale is invalid.
        $result = Carbon::setLocale($locale);

        if (! $result) {
            Log::error("Language '{$locale}' is invalid.");

            $locale = null;
        }
    }
}
