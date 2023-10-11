<?php

namespace Stageo\Model\Repository;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Lib\Database\Table;
use Stageo\Model\Object\CoreObject;

abstract class CoreRepository
{
    protected abstract function getObject(): CoreObject;

    protected function getTable(): ?string
    {
        foreach ((new ReflectionClass($this->getObject()))->getAttributes() as $attribute) {
            $annotationInstance = $attribute->newInstance();
            if ($annotationInstance instanceof Table) {
                return $annotationInstance->getName();
            }
        }
        return null;
    }

    /**
     * Returns an array of objects that match the given conditions.
     *
     * @param QueryCondition|QueryCondition[]|null $conditions Optional instance of {@link QueryCondition} or array of.
     * @param int $limit Maximum number of objects to return
     * @return CoreObject[] Array of rows that match the given conditions. Empty array if no rows is matching.
     * @throws Exception
     */
    public function select(QueryCondition|array $conditions = null,
                           int                  $limit = 999): array
    {
        $pdo = DatabaseConnection::getPdo()->prepare(<<<SQL
            SELECT *
            FROM {$this->getTable()}
            WHERE {$this->conditionsToString($conditions)}
            LIMIT $limit;
        SQL
        );
        $pdo->execute($this->prepareValues($conditions));

        for ($objectArray = $pdo->fetch();
             $objectArray != false;
             $objectArray = $pdo->fetch()) {
            $objects[] = $this->getObject()->construct($objectArray);
        }
        return $objects ?? [];
    }

    public function insert(CoreObject $object): int|false
    {
        $columns = implode(", ", array_map(fn($column) => "`$column`", $object->getNonNullPropertiesName()));
        $values = implode(", ", array_map(fn($column) => ":$column", $object->getNonNullPropertiesName()));
        $pdo = DatabaseConnection::getPdo()->prepare(<<<SQL
            INSERT INTO {$this->getTable()} ($columns)
            VALUES ($values);
        SQL
        );
        return $pdo->execute($object->toArray())
            ? (int) DatabaseConnection::getPdo()->lastInsertId()
            : false;
    }

    /**
     * @param CoreObject $object Object to update, must have primary key set if $conditions is not set. In case it
     * is, all matching rows will be updated. Null values are ignored, use {@link NullDataType} to update values to Null.
     * @param QueryCondition|QueryCondition[]|null $conditions Optional instance of {@link QueryCondition} or array
     * of. If null, the given object's primary key is used.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(CoreObject           $object,
                           QueryCondition|array $conditions = null): bool
    {
        if ($conditions !== null and is_array($conditions)) {
            foreach ($conditions as $condition) if (!$condition instanceof QueryCondition)
                throw new Exception('$conditions array must only contain instances of QueryCondition.');
        }
        $columns = implode(", ", array_map(fn($column) => "`$column` = :$column", $object->getNonNullPropertiesName()));
        $conditions = ($conditions === null)
            ? implode(" AND ", array_map(fn($column) => "`$column` = :$column", $object->getPrimaryKey()))
            : $this->conditionsToString($conditions);
        $pdo = DatabaseConnection::getPdo()->prepare(<<<SQL
            UPDATE {$this->getTable()}
            SET $columns
            WHERE $conditions;
        SQL
        );
        return $pdo->execute($object->toArray());
    }

    /**
     * @param QueryCondition[] $conditions
     * @return bool
     */
    public function delete(QueryCondition|array $conditions): bool
    {
        $pdo = DatabaseConnection::getPdo()->prepare(<<<SQL
            DELETE FROM {$this->getTable()}
            WHERE {$this->conditionsToString($conditions)};
        SQL
        );
        return $pdo->execute($this->prepareValues($conditions));
    }

    private function conditionsToString(QueryCondition|array|null $conditions): string
    {
        return is_array($conditions) ? implode(" ", $conditions) ?: "true" : $conditions ?? "true";
    }

    /**
     * @param QueryCondition|QueryCondition[] $conditions
     * @return array
     */
    private function prepareValues(QueryCondition|array|null $conditions): array
    {
        /**
         * Ne gère pas les conditions avec plusieurs fois la même colonne, également les conditions demandant
         * plusieurs valeurs (IN, NOT IN, BETWEEN, NOT BETWEEN)
         */
        if (is_array($conditions)) {
            foreach ($conditions as $condition) {
                $values[$condition->getColumn()] = $condition->getValue();
            }
        }
        return !is_null($conditions) ? $values ?? [$conditions->getColumn() => $conditions->getValue()] : [];
    }
}