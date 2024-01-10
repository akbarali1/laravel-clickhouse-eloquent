<?php

declare(strict_types=1);

namespace LaravelClickhouseEloquent;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;

class QueryGrammar extends Grammar
{
    public const PARAMETER_SIGN = '#@?';

    /** @inheritDoc */
    public function parameterize(array $values): string
    {
        $params = [];
        for ($i = 0, $iMax = count($values); $i < $iMax; $i++) {
            $params[] = ":$i";
        }

        return implode(', ', $params);
    }

    /** @inheritDoc */
    public function parameter($value)
    {
        return $this->isExpression($value) ? $this->getValue($value) : self::PARAMETER_SIGN;
    }

    /** @inheritDoc */
    public function compileWheres(Builder $query): string
    {
        return static::prepareParameters(parent::compileWheres($query));
    }

    /**
     * Second part of trick to change signs "?" to ":0", ":1" and so on
     * @param string $sql
     * @return string
     */
    public static function prepareParameters(string $sql): string
    {
        $parameterNum = 0;
        while (($pos = strpos($sql, self::PARAMETER_SIGN)) !== false) {
            $sql = substr_replace($sql, ":$parameterNum", $pos, strlen(self::PARAMETER_SIGN));
            $parameterNum++;
        }

        return $sql;
    }

    /** @inheritDoc */
    protected function compileDeleteWithoutJoins(Builder $query, $table, $where): string
    {
        return "alter table {$table} delete {$where}";
    }
}
