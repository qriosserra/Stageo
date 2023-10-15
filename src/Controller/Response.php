<?php

namespace Stageo\Controller;

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\RouteName;
use Stageo\Lib\enums\StatusCode;

class Response
{
    public function __construct(private readonly ?string $template = null,
                                private readonly ?Action $action = null,
                                private readonly array   $params = [])
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
    public function getAction(): ?Action
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