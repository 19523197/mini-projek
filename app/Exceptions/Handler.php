<?php

namespace App\Exceptions;

use App\Treasures\Utility\Translation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        EntityNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        [$statusCode, $data] = $this->prepareException($exception);

        if ($statusCode === 500 && config('app.debug')) {
            return parent::render($request, $exception);
        }

        return response()->json($data, $statusCode);
    }

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
            $statusCode
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
            $statusCode = 400;
            $data['message'] = $data['info'] = $exception->getMessage();
        }

        return [
            $statusCode,
            $data
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
                $exception->getStatusCode()
            ];
        }

        $message = $exception->getMessage();
        $message = is_string($message) && (trim($message) === '') ? get_class($exception) : $message;

        if (! config('app.debug')) {
            $message = __('http_500');
        }

        return [
            $message,
            500
        ];
    }
}
