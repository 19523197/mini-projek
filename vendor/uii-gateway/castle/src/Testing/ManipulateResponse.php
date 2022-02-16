<?php

namespace UIIGateway\Castle\Testing;

use Illuminate\Support\Arr;

trait ManipulateResponse
{
    /**
     * Get the response as json.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function jsonResponse($key = null)
    {
        return Arr::get(json_decode($this->response->getContent(), true), $key);
    }

    /**
     * Dump the response content.
     *
     * @return $this
     */
    protected function dumpResponse()
    {
        $content = $this->response->getContent();

        $json = json_decode($content);

        if (json_last_error() === JSON_ERROR_NONE) {
            $content = $json;
        }

        dump($content);

        return $this;
    }
}
