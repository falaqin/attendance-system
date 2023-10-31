<?php
namespace App\Enums;

enum HttpStatusCode: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case CONFLICT = 409;
    case UNSUPPORTED_MEDIA_TYPE = 415;
    case UNPROCESSABLE_ENTITY = 422;
    case TOO_MANY_REQUESTS = 429;
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;
    case GATEWAY_TIMEOUT = 504;
    case HTTP_VERSION_NOT_SUPPORTED = 505;

    public function label(): string
    {
        return match ($this) {
            HttpStatusCode::OK => 'OK',
            HttpStatusCode::CREATED => 'Created',
            HttpStatusCode::ACCEPTED => 'Accepted',
            HttpStatusCode::NO_CONTENT => 'No Content',
            HttpStatusCode::BAD_REQUEST => 'Bad Request',
            HttpStatusCode::UNAUTHORIZED => 'Unauthorized',
            HttpStatusCode::FORBIDDEN => 'Forbidden',
            HttpStatusCode::NOT_FOUND => 'Not Found',
            HttpStatusCode::METHOD_NOT_ALLOWED => 'Method Not Allowed',
            HttpStatusCode::CONFLICT => 'Conflict',
            HttpStatusCode::UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
            HttpStatusCode::UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
            HttpStatusCode::TOO_MANY_REQUESTS => 'Too Many Requests',
            HttpStatusCode::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            HttpStatusCode::NOT_IMPLEMENTED => 'Not Implemented',
            HttpStatusCode::BAD_GATEWAY => 'Bad Gateway',
            HttpStatusCode::SERVICE_UNAVAILABLE => 'Service Unavailable',
            HttpStatusCode::GATEWAY_TIMEOUT => 'Gateway Timeout',
            HttpStatusCode::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        };
    }
}
