<?php
declare(strict_types=1);

namespace LaravelClickhouseEloquent\Expressions;

use ClickHouseDB\Query\Expression\Expression;

/**
 * Class InsertArray
 * @package LaravelClickhouseEloquent
 *
 * Used to insert Array datatype
 * @link    https://clickhouse.tech/docs/ru/sql-reference/data-types/array/
 * @example Model::insertAssoc([[1,'str',new InsertArray(['a','b'])]]);
 */
class InsertArray implements Expression
{
    public const TYPE_STRING        = 'string';
    public const TYPE_STRING_ESCAPE = 'string_e';
    // Can also be used for float types
    public const TYPE_DECIMAL = 'decimal';
    public const TYPE_INT     = 'int';

    private string $expression;

    /**
     * @param array  $items
     * @param string $type
     */
    public function __construct(array $items, string $type = self::TYPE_STRING)
    {
        $this->expression = match ($type) {
            self::TYPE_INT           => "[".implode(",", array_map('intval', $items))."]",
            self::TYPE_DECIMAL       => "[".implode(",", array_map('floatval', $items))."]",
            self::TYPE_STRING_ESCAPE => "['".implode("','", array_map(static fn($item) => str_replace("'", "\'", $item), $items))."']",
            default                  => "['".implode("','", $items)."']",
        };
    }

    /**
     * @return bool
     */
    public function needsEncoding(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->expression;
    }
}
