<?php

namespace App\Treasures\Utility;

use Illuminate\Support\Str;

class TitleCase
{
    /**
     * Original words.
     *
     * @var string
     */
    protected string $original;

    /**
     * Title cased words.
     *
     * @var string
     */
    protected string $titleCased;

    protected static array $keepLower = [
        'id' => [
            'yang', 'serta', 'dan', 'dengan', 'atau', 'untuk',
        ],
    ];

    public function __construct(string $words, $locale = 'id')
    {
        $this->original = $words;
        $this->titleCased = self::convert($words, $locale);
    }

    public static function convert(string $words, $locale = 'id'): string
    {
        return collect(explode(' ', Str::title($words)))
            ->map(function (string $word, $key) use ($locale) {
                $keepWords = static::$keepLower[$locale] ?? [];

                if ($key !== 0 && in_array(mb_strtolower($word), $keepWords)) {
                    // we keep words in keepWords as lowercase,
                    // when it's not in the first word.
                    return mb_strtolower($word);
                }

                return $word;
            })
            ->implode(' ');
    }

    public function __toString(): string
    {
        return $this->titleCased;
    }
}
