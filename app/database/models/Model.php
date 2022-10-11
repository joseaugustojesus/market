<?php

namespace app\database\models;

use app\database\Connection;
use app\database\Filters;
use app\database\Pagination;
use PDO;
use PDOException;

abstract class Model
{
    private $fields = '*';
    private $filters = '';
    private $pagination = '';

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function setFilters(Filters $filters)
    {
        $this->filters = $filters->dump();
    }

    public function clearFilters()
    {
        $this->filters = null;
    }


    public function setPagination(Pagination $pagination)
    {
        $pagination->setTotalItems($this->count());
        $this->pagination = $pagination->dump();
    }


    public function create(array $data)
    {
        try {
            $sql = "INSERT INTO {$this->table} (";
            $sql .= implode(', ', array_keys($data)) . ') VALUES(:';
            $sql .= implode(', :', array_keys($data)) . ')';

            $connection = Connection::instance();
            $prepare = $connection->prepare($sql);
            $prepare->execute($data);
            return $connection->lastInsertId();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function update(string $field, $fieldValue, array $data)
    {
        try {

            $sql = "UPDATE {$this->table} SET ";
            foreach ($data as $key => $value) {
                $sql .= "{$key} = :{$key}, ";
            }
            $sql = rtrim($sql, ', ');
            $sql .= " WHERE {$field} = :{$field}";

            $data[$field] = $fieldValue;
            $connection = Connection::instance();
            $prepare = $connection->prepare($sql);
            return $prepare->execute($data);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function all()
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->table}{$this->filters} {$this->pagination}";
            $connection = Connection::instance();
            $query = $connection->query($sql);
            return $query->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } catch (PDOException $e) {
            echo ($e->getMessage());
            die;
        }
    }

    public function findBy(array $conditions)
    {
        try {

            $filters = new Filters;


            foreach ($conditions as $index => $condition) {
                $field = $condition[0];
                $comparator = $condition[1];
                $value = $condition[2];
                $logic = isset($condition[3]) ? $condition[3] : '';
                $filters->where($field, $comparator, $value, $logic);
            }
            $this->setFilters($filters);


            $sql = "SELECT * FROM {$this->table} {$this->filters} {$this->pagination}";
            $connection = Connection::instance();

            return $connection->query($sql)->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }


    public function findByOne(string $field = '', string $operator = '=', string $value = '')
    {
        try {
            $sql = (!$this->filters) ?
                "SELECT {$this->fields} FROM {$this->table} WHERE {$field} {$operator} :{$field}" :
                "SELECT {$this->fields} FROM {$this->table} {$this->filters}";

            $connection = Connection::instance();
            $prepare = $connection->prepare($sql);
            $prepare->execute(!$this->filters ? [$field => $value] : []);

            return $prepare->fetchObject(get_called_class());
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }



    public function first(string $field = 'id', $order = 'asc')
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->table} ORDER BY {$field} {$order}";
            $connection = Connection::instance();
            $query = $connection->query($sql);
            return $query->fetchObject(get_called_class());
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }


    public function delete(string $field = '', $value = '')
    {
        try {
            $sql = (!$this->filters) ?
                "DELETE FROM {$this->table} WHERE {$field} = :{$field}" :
                "DELETE FROM {$this->table} {$this->filters}";
            $connection = Connection::instance();
            $prepare = $connection->prepare($sql);
            return $prepare->execute(!$this->filters ? [$field => $value] : []);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function count()
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->table} {$this->filters}";
            $connection = Connection::instance();
            $query = $connection->query($sql);
            return $query->rowCount();
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function rawinstance()
    {
        return Connection::instance();
    }

    public function rawIntranetOldHomologation()
    {
        return Connection::intranetOldHomologation();
    }

    public function rawLogixProduction()
    {
        return Connection::logixProduction();
    }

    public function rawPowerbiProduction()
    {
        return Connection::powerbiProduction();
    }

    public function rawTableauProduction()
    {
        return Connection::tableauProduction();
    }
}
