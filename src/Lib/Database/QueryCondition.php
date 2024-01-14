<?php

namespace Stageo\Lib\Database;
/**
 * Cette classe représente une condition de requête SQL, définissant une comparaison entre une colonne, un opérateur de comparaison
 * et une valeur associée. Elle peut également spécifier un opérateur logique pour la combiner avec d'autres conditions.
 *
 * @param string             $column             Nom de la colonne sur laquelle s'applique la condition.
 * @param ComparisonOperator $comparisonOperator Opérateur de comparaison (par exemple, "=", "<>", "LIKE", etc.).
 * @param mixed              $value              Valeur associée à la condition (peut être un seul ou plusieurs éléments pour certains opérateurs).
 * @param LogicalOperator   $logicalOperator    (Facultatif) Opérateur logique pour combiner cette condition avec d'autres (AND, OR, etc.).
 *
 * @param string getColumn()                  Retourne le nom de la colonne.
 * @param ComparisonOperator getComparisonOperator() Retourne l'opérateur de comparaison.
 * @param mixed getValue()                    Retourne la valeur associée à la condition.
 * @param LogicalOperator getLogicalOperator() (Facultatif) Retourne l'opérateur logique.
 * @param string __toString()                 Convertit la condition en chaîne de caractères pour une utilisation dans une requête SQL.
 *
 */


class QueryCondition
{
    public function __construct(private readonly string             $column,
                                private readonly ComparisonOperator $comparisonOperator,
                                private readonly mixed              $value,
                                private readonly ?LogicalOperator   $logicalOperator = null)
    {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getComparisonOperator(): ComparisonOperator
    {
        return $this->comparisonOperator;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getLogicalOperator(): LogicalOperator
    {
        return $this->logicalOperator;
    }

    public function __toString(): string
    {
        if (in_array($this->comparisonOperator, [ComparisonOperator::BETWEEN, ComparisonOperator::NOT_BETWEEN]))
            $value = implode(" AND ", $this->value);
        else if (in_array($this->comparisonOperator, [ComparisonOperator::IN, ComparisonOperator::NOT_IN]))
            $value = "(" . implode(", ", $this->getValue()) . ")";
        else
            $value = ":$this->column";

        return is_null($this->logicalOperator)
            ? implode(" ", ["`$this->column`", $this->comparisonOperator->value, $value])
            : implode(" ", ["`$this->column`", $this->comparisonOperator->value, $value, $this->logicalOperator->value]);
    }
}