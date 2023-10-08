<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\enums\FlashType;

class UnauthorizedRequestException extends ControllerException
{
    public function __construct(string     $message = "Unauthorized request",
                                RouteName  $routeName = RouteName::ERROR,
                                FlashType  $flashType = FlashType::ERROR,
                                StatusCode $statusCode = StatusCode::UNAUTHORIZED,
                                array      $params = [])
    {
        parent::__construct($message, $routeName, $flashType, $statusCode, $params);
    }
}