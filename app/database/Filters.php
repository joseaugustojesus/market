<?php

namespace app\database;


class Filters
{
    private  $filters = [];

    public function initWithEquals()
    {
        $this->filters['where'][] = '1 = 1 AND ';
    }

    public function finalWithEquals()
    {
        $this->filters['where'][] = '1 = 1';
    }

    public function setParentheses($action = null)
    {
        if($action){
            $this->filters['where'][] = $action;
        }
    }

    public function setOperator($operator = null)
    {
        if($operator){
            $this->filters['where'][] = $operator;
        }
    }


    public function where(string $field, string $operator, $value = null, string $logic = '')
    {
        $formatter = '';

        if(is_array($value)){
            $formatter = "('".implode("','", $value)."')";
        }else if(is_string($value)){
            $formatter = "'{$value}'";
        }else if(is_bool($value)){
            $formatter = $value ? 1 : 0;
        }else {
            $formatter = $value;
        }

        $value = strip_tags($formatter);

        $this->filters['where'][] = "{$field} {$operator} {$value} {$logic}";
    }


    public function limit(int $limit)
    {
        $this->filters['limit'] = " LIMIT {$limit}";
    }

    public function orderBy(string $field, string $order = 'asc')
    {
        $this->filters['order'] = " ORDER BY {$field} {$order}";
    }


    public function join(string $foreignTable, string $joinTableOne, string $operator, string $joinTableTwo, string $joinType = 'inner join')
    {
        $this->filters['join'][] = " {$joinType} {$foreignTable} ON {$joinTableOne} {$operator} {$joinTableTwo}";
    }


    public function dump()
    {
        $filter = !empty($this->filters['join']) ? implode(' ', $this->filters['join']) : '';
        $filter .= !empty($this->filters['where']) ? ' WHERE '.implode(' ', $this->filters['where']) : '';
        $filter .= $this->filters['order'] ?? '';
        $filter .= $this->filters['limit'] ?? '';

        return $filter;
    }
}
