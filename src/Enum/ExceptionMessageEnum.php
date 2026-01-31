<?php

declare(strict_types=1);

namespace App\Enum;

enum ExceptionMessageEnum: string
{
    use EnumTrait;

    case INVALID_JSON = 'invalid json';
    case INVALID_FORMAT = 'invalid format';
    case INVALID_REQUEST_CONTENT = 'invalid request content';
    case NOT_CONNECTED = 'not connected';
    case NOT_FOUND = 'not found';
    case NOT_MATCH = 'not match';
    case FORBIDDEN = 'forbidden';
    case DELETE_FORBIDDEN = 'delete forbidden';
    case ACCESS_FORBIDDEN = 'access forbidden';
    case ALREADY_EXIST = 'already exist';
    case INVALID_HEADER_PARAMETER = 'invalid header parameter';
    case INVALID_ROUTE_PARAMETER = 'invalid route parameter';
    case UNIQUE_PROPERTY = 'unique property';
    case UPLOAD_FAILED = 'upload failed';
    case DOWNLOAD_FAILED = 'download failed';
    case INVALID_FILE_TYPE = 'invalid file type';
    case BUSINESS_INCOHERENCE = 'business incoherence';
}