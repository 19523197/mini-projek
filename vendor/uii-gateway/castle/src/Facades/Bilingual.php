<?php

namespace UIIGateway\Castle\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Utils\LangUtils translate(string $sentence)
 * @method static \App\Utils\LangUtils to(string $lang)
 * @method static string result($replace = [])
 */
class Bilingual extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \UIIGateway\Castle\Utility\FuncBilingual::class;
    }
}
