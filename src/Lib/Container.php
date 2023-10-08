<?php

namespace Stageo\Lib;

class Container
{
    private static array $services;

    public static function addService(string $name,
                                      mixed  $service): void
    {
        Container::$services[$name] = $service;
    }

    public static function getService(string $nom)
    {
        return Container::$services[$nom];
    }
}