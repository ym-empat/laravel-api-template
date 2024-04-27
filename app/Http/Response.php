<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseFacade;

class Response
{
    public const SUCCESS = 200;

    public const BAD_REQUEST = 400;

    public const UNAUTHORIZED = 401;

    public const PAYMENT_REQUIRED = 402;

    public const FORBIDDEN = 403;

    public const NOT_FOUND = 404;

    public const METHOD_NOT_ALLOWED = 405;

    public const VALIDATION_ERROR = 422;

    public const TOO_MANY_ATTEMPTS = 429;

    public const INTERNAL_ERROR = 500;

    public static function send(mixed $data, int $code = self::SUCCESS, array $headers = []): JsonResponse
    {
        $response = new static([
            'success' => true,
            'data' => $data,
        ], $code, $headers);

        return $response();
    }

    public static function error(mixed $data, int $code = self::INTERNAL_ERROR, array $headers = []): JsonResponse
    {
        $response = new static([
            'success' => false,
            'data' => $data,
        ], $code, $headers);

        return $response();
    }

    public function __construct(
        private mixed $data,
        private int $code,
        private array $headers
    ) {
        //
    }

    public function __invoke(): JsonResponse
    {
        return ResponseFacade::json(
            $this->data,
            $this->code,
            $this->headers
        );
    }
}
