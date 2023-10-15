<?php

namespace Stageo\Controller\Exception;

use Exception;
use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;

class ControllerException extends Exception
{
    public function __construct(string                     $message,
                                private readonly Action    $action = Action::ERROR,
                                private readonly FlashType $flashType = FlashType::ERROR,
                                private readonly array     $params = [])
    {
        parent::__construct($message);
    }

    public function getFlashType(): FlashType
    {
        return $this->flashType;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}