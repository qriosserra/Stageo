<?php
function input(
        string $name,
        string $label,
        string $type = "text",
        string $icon = null,
        string $properties = null,
        string $pattern = null,
        string $value = null,
        string $class = null): string
{
    $container = match ($type) {
        "checkbox" => "checkbox-container",
        "toggle" => "toggle-container",
        default => "field-container",
    };
    if (!empty($class))
        $container .= " " . $class;
    $type = ($type == "toggle") ? "checkbox" : $type;
    $icon = (!is_null($icon)) ? "<i class=\"fi {$icon}\"></i>" : "";
    $pattern = (!is_null($pattern)) ? "pattern=\"{$pattern}\"" : "";
    $value = (!is_null($value)) ? "value=\"{$value}\"" : "";
    $attributes = "";
    if ($type != "checkbox" and $type != "toggle")
        $attributes = "autocomplete=\"off\" placeholder=\" \"";
    $checkboxSvg = ($type == "checkbox")
        ? "<span class='checkbox-button'>
                <svg viewbox='-4 -4 20 20'>
                    <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                </svg>
           </span>"
        : "";
    $toggleButton = ($type == "toggle") ? "<span class='toggle-button'></span>" : "";

return <<<HTML
<div class="{$container}">
    {$icon}
    <input id="{$name}"
           name="{$name}"
           type="{$type}"
           {$pattern}
           {$value}
           {$attributes}
           {$properties}>
    <label for="{$name}">
        {$checkboxSvg}
        {$label}
        {$toggleButton}
    </label>
</div>
HTML;
}