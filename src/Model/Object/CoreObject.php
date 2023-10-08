<?php

namespace Stageo\Model\Object;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\NullDataType;

abstract class CoreObject
{
    /**
     * @param array $objectArray
     * @return CoreObject
     * @throws Exception
     */
    public function construct(array $objectArray): static
    {
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            $property->setValue(
                objectOrValue: $this,
                value: $objectArray[$property->getName()]
            );
        }
        return $this;
    }

    public function toArray(bool $setNullValues = false, bool $convertBoolToInt = true): array
    {
        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PRIVATE) as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($setNullValues or !is_null($value))
                $objectArray[$property->getName()] = ($convertBoolToInt and is_bool($value))
                    ? (int) $value
                    : ($value instanceof NullDataType
                        ? null
                        : $value);
        }
        return $objectArray ?? [];
    }

    public function getNonNullPropertiesName(): array
    {
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            if (!is_null($property->getValue($this))) $properties[] = $property->getName();
        }
        return $properties ?? [];
    }

    /**
     * @return string[] Array of primary key columns' names
     */
    public function getPrimaryKey(): array
    {
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            if ($property->getAttributes(PrimaryKey::class))
                $primaryKey[] = $property->getName();
        }
        return $primaryKey ?? [];
    }
}