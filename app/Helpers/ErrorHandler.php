<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ErrorHandler
{

    protected array $exceptionMapping = [
        ModelNotFoundException::class => [
            'view' => 'errors.404',
            'user_message' => 'The requested resource was not found.',
            'http_status_code' => Response::HTTP_NOT_FOUND
        ],
    ];


    public function handleException(Exception $exception,string $userMessage = 'An unexpected error has occurred. Please try again later.',int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        $this->logError($exception,$userMessage,$statusCode);
        $mapping = $this->exceptionMapping[get_class($exception)] ?? null;


        if(request()->wantsJson()){
            return $this->createJsonResponse($mapping['user_message'] ?? $userMessage, $mapping['http_status_code'] ?? $statusCode);
        }

        if ($mapping) {
            return $this->createResponse($mapping['view'], $mapping['user_message'], $mapping['http_status_code']);
        }
        return $this->createResponse('errors.generic', $userMessage, $statusCode);
    }

    protected function logError(Exception $exception, string $userMessage, int $statusCode): void
    {
        Log::error($exception->getMessage(),
        [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            // 'user_message' => $userMessage,
            // 'status_code' => $statusCode
            // 'trace' => $exception->getTraceAsString(),
            // 'request' => request()->except(['password','password_confirmation']),

        ]);
    }

    protected function createResponse(string $view, string $message, int $statusCode): Response
    {
        return response()->view($view, ['message' => $message], $statusCode);
    }

    protected function createJsonResponse(string $message, int $statusCode): Response
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function addExceptionMapping(string $exceptionClass, string $view, string $userMessage, int $statusCode): void
    {
        $this->exceptionMapping[$exceptionClass] = [
            'view' => $view,
            'user_message' => $userMessage,
            'http_status_code' => $statusCode,
        ];
    }

}
