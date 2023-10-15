<?php

namespace Stageo\Lib;

use Stageo\Lib\enums\Action;

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
     * @return Action|null
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