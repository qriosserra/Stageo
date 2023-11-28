<?php

namespace Stageo\Lib\Database;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
#[\Attribute]
class CompositePrimaryKey
{
    /**
     * @var array<string>
     */
    public array $columns;

    public function __construct(string ...$columns)
    {
        $this->columns = $columns;
    }
}
