<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;
use Stageo\Lib\enums\FlashType;

class InvalidTokenException extends ControllerException
{
    public function __construct(string    $message = "Le token est invalide",
                                Action    $action = Action::ERROR,
                                FlashType $flashType = FlashType::ERROR,
                                array     $params = [])
    {
        parent::__construct($message, $action, $flashType, $params);
    }
}