<?php

namespace Stageo\Lib;

use Stageo\Controller\Exception\ControllerException;

class EnvLoader
{
    /**
     * @throws ControllerException
     */
    public static function load($path): void
    {
        if (is_dir($path))
            $path = rtrim($path, "/\\") . DIRECTORY_SEPARATOR . ".env";
        if (!file_exists($path))
            throw new ControllerException("The .env file does not exist");
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false)
            throw new ControllerException("Error reading .env file");
        foreach ($lines as $line) {
            // Remove comments and trim whitespace
            $line = trim(preg_replace('/\s*#.*$/', "", $line));
            // Skip if line is empty
            if (empty($line)) continue;
            list($key, $value) = explode("=", $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Handle values enclosed with quotes
            if (preg_match('/^"(.*)"$/', $value, $matches))
                $value = $matches[1];
            $_ENV[$key] = $value;
        }
    }
}