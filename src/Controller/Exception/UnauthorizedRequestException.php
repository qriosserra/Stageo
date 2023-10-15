<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;

class UnauthorizedRequestException extends ControllerException
{
    public function __construct(string    $message = "Requête non-authorisée",
                                Action    $action = Action::ERROR,
                                FlashType $flashType = FlashType::ERROR,
                                array     $params = [])
    {
        parent::__construct($message, $action, $flashType, $params);
    }
}