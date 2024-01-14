<?php

namespace Stageo\Lib\Database;
/*
 * liste des operateur logic dans des requetes SQL
 */
enum LogicalOperator: string
{
    case AND = "AND";
    case OR = "OR";
}