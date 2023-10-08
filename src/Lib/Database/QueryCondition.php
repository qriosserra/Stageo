<?php

namespace Stageo\Lib\Database;

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