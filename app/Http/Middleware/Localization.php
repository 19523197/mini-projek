<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Support\Facades\File;

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

        app()->setLocale($locale);

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

    protected function validateLocale($locale)
    {
        if (is_null($locale)) {
            throw new Exception('Language is not available.');
        }

        // detect valid locale via Carbon translations.
        // we assume, if locale isn't available in Carbon, it means the locale is invalid.
        $result = Carbon::setLocale($locale);

        if (!$result) {
            throw new Exception("Language '{$locale}' is invalid.");
        }
    }
}
