<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\enums\FlashType;

class TokenTimeoutException extends ControllerException
{
    public function __construct(RouteName  $routeName,
                                string     $message = "Token timed out",
                                FlashType  $flashType = FlashType::ERROR,
                                StatusCode $statusCode = StatusCode::REQUEST_TIMEOUT,
                                array      $params = [])
    {
        parent::__construct($message, $routeName, $flashType, $statusCode, $params);
    }
}