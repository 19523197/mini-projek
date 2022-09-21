<?php

namespace UIIGateway\Castle\Utility;

class NameFormatter
{
    public static function titleCased(
        string $name,
        ?string $frontTitle = null,
        ?string $backTitle = null
    ): string {
        if (! blank($frontTitle)) {
            $frontTitle .= ' ';
        }

        if (! blank($backTitle)) {
            $backTitle = ', ' . $backTitle;
        }

        return $frontTitle . TitleCase::convert($name) . $backTitle;
    }
}
