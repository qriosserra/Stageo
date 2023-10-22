<?php

function breadcrumb(int $index, array $links): string
{
    $list = "";
    $i = 0;
    foreach ($links as $text => $action) {
        $class = "";
        $i++;
        if ($index === $i) $class = "!font-extrabold underline underline-offset-2";
        $list .= <<<HTML
            <li><a href="$action" class="button-ghost $class"><span>$text</span></a></li><i class="fi fi-rr-angle-small-right"></i>
        HTML;
    }
    return <<<HTML
        <ul class="absolute w-max top-16 flex justify-between items-center gap-4">
            $list
        </ul>    
    HTML;
}