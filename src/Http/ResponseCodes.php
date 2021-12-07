<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Http;

class ResponseCodes{

    public static function isInvalid(int $statusCode): bool
    {
        return $statusCode < 100 || $statusCode >= 600; 
    }

    public static function isInformational(int $statusCode): bool
    {
        return $statusCode >= 100 && $statusCode < 200;
    }

    public static function isSuccessful(int $statusCode): bool
    {
        return $statusCode >= 200 && $statusCode < 300; 
    }

    public static function isRedirection(int $statusCode): bool
    {
        return $statusCode >= 300 && $statusCode < 400;
    }

    public static function isClientError(int $statusCode): bool
    {
        return $statusCode >= 400 && $statusCode < 500;
    }

    public static function isServerError(int $statusCode): bool
    {
        return $statusCode >= 500 && $statusCode < 600;
    }

    public function isOk(int $statusCode): bool
    {
        return 200 === $statusCode;
    }

    public function isForbidden(int $statusCode): bool
    {
        return 403 === $statusCode;
    }

    public function isNotFound(int $statusCode): bool
    {
        return 404 === $statusCode;
    }

    public function isEmpty(int $statusCode): bool
    {
        return \in_array($statusCode, [204, 304]);
    }
}