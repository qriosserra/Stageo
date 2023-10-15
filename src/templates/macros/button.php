<?php
function button($text, $icon, $url, $class):string
{
    return <<<HTML
        <a href="$url" class="button-ghost $class">
            <i class="fi $icon"></i>
            <span>$text</span>
        </a>
    HTML;
}