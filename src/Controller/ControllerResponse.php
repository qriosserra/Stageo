<?php

namespace Stageo\Controller;

use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;

class ControllerResponse
{
    public function __construct(private readonly ?string    $template = null,
                                private readonly ?RouteName $redirection = null,
                                private readonly StatusCode $statusCode = StatusCode::OK,
                                private readonly array      $params = [])
    {
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @return RouteName|null
     */
    public function getRedirection(): ?RouteName
    {
        return $this->redirection;
    }

    /**
     * @return StatusCode
     */
    public function getStatusCode(): StatusCode
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}