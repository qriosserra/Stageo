<?php

use Stageo\Lib\enums\Action;

function button(string        $text,
                string        $icon,
                string|Action $url,
                string        $class,
                ?string        $classicon = null):string
{
    if ($url instanceof Action)
        $url = $url->value;
    return <<<HTML
        <a href="$url" class="button-ghost $class">
            <i class="fi $icon $classicon"></i>
            <span>$text</span>
        </a>
    HTML;
}