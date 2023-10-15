<?php

namespace Stageo\Controller\Exception;

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;

class TokenTimeoutException extends ControllerException
{
    public function __construct(Action    $action,
                                string    $message = "Le token a expiré",
                                FlashType $flashType = FlashType::ERROR,
                                array     $params = [])
    {
        parent::__construct($message, $action, $flashType, $params);
    }
}