<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\enums\FlashType;

class InvalidTokenException extends ControllerException
{
    public function __construct(string     $message = "Invalid token",
                                RouteName  $routeName = RouteName::ERROR,
                                FlashType  $flashType = FlashType::ERROR,
                                StatusCode $statusCode = StatusCode::BAD_REQUEST,
                                array      $params = [])
    {
        parent::__construct($message, $routeName, $flashType, $statusCode, $params);
    }
}