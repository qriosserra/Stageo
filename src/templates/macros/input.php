<?php

use Stageo\Lib\enums\Pattern;

function field(
    string  $name,
    string  $label,
    string  $type = "text",
    string  $placeholder = null,
    Pattern $pattern = null,
    bool    $required = false,
    string  $value = null,
    string  $class = null): string
{
    is_null($class)
        ? $class = ""
        : $class = "class='$class'";
    $type === "float"
        ? $type = "type='number' step='0.01'"
        : $type = "type='$type'";
    $pattern = is_null($pattern)
        ? $pattern = ""
        : $pattern = $required
            ? "pattern='{$pattern->value}'"
            : "pattern='({$pattern->value})|(^$)'";
    $required = !$required
        ? $required = ""
        : $required = "required";

    return <<<HTML
    <div $class>
        <input autocomplete="off" 
               id="$name" 
               name="$name" 
               $type 
               class="focus:border-rose-600 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none" 
               placeholder="$placeholder" 
               $pattern 
               $required 
               value="$value">
        <label for="$name" 
               class="peer-placeholder-shown:text-gray-440 absolute -top-3.5 left-0 text-sm text-gray-600 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-gray-600">
            $label
        </label>
    </div>
    HTML;
}

function dropdown(string $name,
                  string $label,
                  string $placeholder = null,
                  string $class = null,
                  string $default = null,
                  array  $options = []): string
{
    is_null($class)
        ? $class = ""
        : $class = "class='$class'";
    $html = <<<HTML
    <div $class>
        <label for="$name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">$label</label>
        <select id="$name" name="$name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    HTML;
    if (!is_null($placeholder))
        is_null($default)
            ? $html .= "<option selected=''>$placeholder</option>"
            : $html .= "<option>$placeholder</option>";
    foreach ($options as $value => $text) {
        $selected = ($value == $default) ? " selected=''" : "";
        $html .= "<option value='$value' $selected>$text</option>";
    }
    return $html . "</select></div>";
}

function textarea(
    string $name,
    string $label,
    string $placeholder = "",
    int    $rows = 4,
    bool   $required = false,
    string $value = null,
    string $class = null): string
{
    is_null($class)
        ? $class = ""
        : $class = "class='$class'";
    $placeholder = "placeholder='$placeholder'";
    $required = !$required
        ? $required = ""
        : $required = "required";
    return <<<HTML
        <div $class>
            <label for="$name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">$label</label>
            <textarea id="$name" name="$name" $required rows="$rows" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" $placeholder>$value</textarea>
        </div>
    HTML;
}

function token(string $token): string
{
    return "<input name='token' type='hidden' value='$token'>";
}

function submit(string $text, string $class = ""): string
{
    $class = "class='button-primary $class'";
    return <<<HTML
        <input type="submit" value="$text" $class>
    HTML;
}