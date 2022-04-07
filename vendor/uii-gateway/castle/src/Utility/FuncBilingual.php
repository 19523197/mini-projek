<?php

namespace UIIGateway\Castle\Utility;

class FuncBilingual
{
    private $language;
    private $sentence;
    private $availableLanguange = ['id', 'en'];

    public function __construct(\Illuminate\Http\Request $request)
    {
        if ($request->headers->has('x-language')) {
            $lang = $request->header('x-language');
            if (in_array($lang, $this->availableLanguange)) {
                $lang = $lang == '' || $lang == null ? 'id' : $lang;
            } else {
                $lang = 'id';
            }
            $this->language = $lang;
        } else {
            $this->language = 'id';
        }
    }

    public function translate($sentence)
    {
        $this->sentence = $sentence;
        return $this;
    }

    public function to($language)
    {
        $this->language = $language;
        return $this;
    }

    public function result($replace = [])
    {
        if (count($replace) > 0) {
            $replace = array_map('strval', $replace);

            foreach ($replace as $i => $rep) {
                $trans = trans('dictionary.' . $rep, []);
                if (strpos($trans, 'dictionary.') !== false) {
                    $replace[$i] = $rep;
                } else {
                    $replace[$i] = $trans;
                }
            }
        }

        $translate = trans('dictionary.' . $this->sentence, $replace);
        if (strpos($translate, 'dictionary.') !== false) {
            return $this->sentence;
        } else {
            return $translate;
        }
    }
}
