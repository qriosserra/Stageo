<?php

namespace Stageo\Lib\Database;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
#[\Attribute]
class Association
{
    private Table $table;

    public function __construct(string         $table,
                                private string $id_foreign_key,
                                private string $value)
    {
        $this->table = new Table($table);
    }

    public function getTable(): string
    {
        return $this->table->getName();
    }

    /**
     * @return string
     */
    public function getIdForeignKey(): string
    {
        return $this->id_foreign_key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}