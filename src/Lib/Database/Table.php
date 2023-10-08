<?php

namespace Stageo\Lib\Database;

/**
 * @Annotation
 * @Target("CLASS")
 */
#[\Attribute]
class Table
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $_ENV["DATABASE_PREFIX"] . $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}