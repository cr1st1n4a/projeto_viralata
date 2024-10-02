<?php

namespace app\database\builder;

use app\database\Connection;

class DeleteQuery
{
    private string $table;
    private array $where = [];
    private array $binds = [];

    public static function table(string $table)
    {
        $self = new self;
        $self->table = $table;
        return $self;
    }

    public function where(string $field, string $operator, string|int $value, ?string $logic = null)
    {
        $placeHolder = $field;
        if (str_contains($placeHolder, '.')) {
            $placeHolder = substr($field, strpos($field, '.') + 1);
        }
        $this->where[] = "{$field} {$operator} :{$placeHolder} {$logic}";
        $this->binds[$placeHolder] = $value;
        return $this;
    }

    private function createQuery()
    {
        if (!$this->table) {
            throw new \Exception("A consulta precisa invocar o método table.");
        }

        $query = "delete from {$this->table}";
        if (count($this->where) > 0) {
            $query .= ' WHERE ' . implode(' ', $this->where);
        }
        return $query;
    }

    public function delete()
    {
        $query = $this->createQuery();
        try {
            $connection = Connection::open();
            $prepare = $connection->prepare($query);
            return $prepare->execute($this->binds ?? []);
        } catch (\PDOException $e) {
            throw new \Exception("Restrição: {$e->getMessage()}, SQL: " . $query);
        }
    }
}