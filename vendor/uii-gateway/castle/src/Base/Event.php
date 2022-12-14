<?php

namespace UIIGateway\Castle\Base;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

abstract class Event
{
    use SerializesModels;

    public array $requestHeaders;

    public string $publisherScope;

    public string $publisher;

    public string $publishedAt;

    public function __construct()
    {
        $this->requestHeaders = Arr::only(request()->header(), [
            'x-organization',
            'x-member',
            'x-language',
            'x-student',
            'x-university',
            'x-app',
            'x-menu',
        ]);
        $this->publisherScope = env('APP_SCOPE_NAME', '');
        $this->publisher = config('app.name', '');
        $this->publishedAt = Carbon::now()->toDateTimeString();
    }

    public function publishWith()
    {
        return [
            'topic' => $this->topic ?? null,
            'publisherScope' => $this->publisherScope,
            'publisher' => $this->publisher,
            'publishedAt' => $this->publishedAt,
        ];
    }

    public function publishAs()
    {
        return class_basename($this);
    }
}
