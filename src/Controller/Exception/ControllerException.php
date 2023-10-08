<?php

namespace Stageo\Controller\Exception;

use Exception;
use Stageo\Lib\enums\FlashType;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;

class ControllerException extends Exception
{
    public function __construct(string                      $message,
                                private readonly RouteName  $redirection = RouteName::ERROR,
                                private readonly FlashType  $flashType = FlashType::ERROR,
                                private readonly StatusCode $statusCode = StatusCode::BAD_REQUEST,
                                private array      $params = [])
    {
        parent::__construct($message);
        $this->params["statusCode"] = $this->statusCode->value;
    }

    public function getStatusCode(): StatusCode
    {
        return $this->statusCode;
    }

    public function getFlashType(): FlashType
    {
        return $this->flashType;
    }

    /**
     * @return RouteName
     */
    public function getRedirection(): ?RouteName
    {
        return $this->redirection;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}