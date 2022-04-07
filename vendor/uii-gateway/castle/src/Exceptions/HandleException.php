<?php

namespace UIIGateway\Castle\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\DetectsLostConnections;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;
use UIIGateway\Castle\Utility\Translation;

trait HandleException
{
    use DetectsLostConnections;

    /**
     * Prepare exception for api endpoint.
     *
     * @param  \Throwable  $exception
     * @return array
     */
    protected function prepareException(Throwable $exception)
    {
        [
            $message,
            $statusCode,
        ] = $this->getExceptionDetail($exception);

        $message = mb_convert_encoding($message, 'UTF-8', 'auto');

        $data = [
            'message' => $message, // legacy
            'info' => $message,
        ];

        if ($exception instanceof AuthenticationException) {
            $data['message'] = $data['info'] = __('http_401');
            $statusCode = 401;
        } elseif ($exception instanceof AuthorizationException) {
            $data['message'] = $data['info'] = __('http_403');
            $statusCode = 403;
        } elseif ($exception instanceof ModelNotFoundException) {
            $model = $exception->getModel();

            $data['message'] = $data['info'] = __(':entity is not found.', [
                'entity' => Translation::transEntity($model),
                'key' => (new $model)->getRouteKeyName(),
            ]);
            $statusCode = 400;
        } elseif ($exception instanceof ValidationException) {
            $data = array_merge($data, [
                'message' => __('http_422'),
                'info' => array_map(function (array $messages) {
                    // We only interested on the first error message on each field.
                    return [Arr::first($messages)];
                }, $exception->errors()),
            ]);
            $statusCode = 400;
        } elseif ($exception instanceof EntityNotFoundException) {
            $statusCode = 404;
            $data['message'] = $data['info'] = $exception->getMessage();
        }

        return [
            $statusCode,
            $data,
        ];
    }

    /**
     * Mapped the exception message and code.
     *
     * @param  \Throwable  $exception
     * @return array
     */
    protected function getExceptionDetail(Throwable $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            return [
                $this->getHttpExceptionMessage($exception),
                $exception->getStatusCode(),
            ];
        }

        $message = $exception->getMessage();
        $message = is_string($message) && (trim($message) === '') ? get_class($exception) : $message;

        if (! config('app.debug')) {
            $message = __('http_500');
        }

        return [
            $message,
            500,
        ];
    }

    /**
     * Get the proper HTTP Exception message.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $exception
     * @return string
     */
    protected function getHttpExceptionMessage(HttpExceptionInterface $exception)
    {
        $message = $exception->getMessage();
        $statusCode = $exception->getStatusCode();

        $key = 'http_' . $statusCode;

        if (is_string($message) && (trim($message) === '')) {
            if (($text = __($key)) && $text !== $key) {
                $message = $text;
            } elseif (array_key_exists($statusCode, Response::$statusTexts)) {
                $message = Response::$statusTexts[$statusCode];
            } else {
                $message = __('http_500');
            }
        }

        return $message;
    }

    /**
     * Determine if the exception should not reported.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    protected function shouldntReport(Throwable $e)
    {
        $errorInQueue = ! is_null(collect($e->getTrace())
            ->pluck('file')
            ->first(fn ($item) => Str::endsWith($item, '/illuminate/queue/Worker.php')));

        if (
            env('IS_LOCAL') &&
            $errorInQueue &&
            (int) Cache::get('LOST_CONNECTION_COUNT', 0) > 1 &&
            (
                $this->causedByLostConnection($e) ||
                Str::contains($e->getMessage(), [
                    // phpcs:disable Generic.Files.LineLength.MaxExceeded
                    'SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known',
                    // phpcs:enable
                ])
            )
        ) {
            // This is just to prevent logged every lost connection when running Queue Work.
            // For example, we may encounter annoying large logs when running worker in Docker container
            // and we don't connect to the VPN.
            return true;
        }

        return parent::shouldntReport($e);
    }
}
