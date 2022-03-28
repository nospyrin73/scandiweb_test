<?php

namespace App\Database;

use PDOStatement;

class Query {
    private string $statement;

    private PDOStatement $result;

    public function __construct(
        private Database $database,
        private Table $table
    ) {}

    public function select(array $columns): self {
        $this->statement = 
            'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->table->getName();

        return $this;
    }

    public function delete(): self {
        $this->statement =
            'DELETE FROM ' . $this->table->getName();
        
        return $this;
    }

    public function insert(array $data, bool $multiple = false): self {
        $this->statement = 
            'INSERT INTO ' . $this->table->getName() . ' (' . implode(', ', array_keys($data)) . ') ';

        if ($multiple) {
            // get n of insertions
            $count = count(reset($data));

            $this-> statement .= 'VALUES ';

            for ($i = 0; $i < $count; $i++) {
                $this->statement .= '(' . implode(', ', array_column($data, $i)) . ')';

                // if not last
                if ($i + 1 !== $count) {
                    $this->statement .= ', ';
                }
            }
            
        } else {
            $this->statement .= 'VALUES (' . implode(', ', array_values($data)) . ')';
        }

        return $this;
    }

    public function where(): self {
        $this->statement .= ' WHERE ';
    
        return $this;
    }

    public function condition(string $loperand, string $operator, $roperand): self {
        $this->statement .= "${loperand} ${operator} ${roperand}";

        return $this;
    }

    public function not(): self {
        $this->statement .= " NOT ";

        return $this;
    }

    public function and(): self {
        $this->statement .= " AND ";

        return $this;
    }

    public function or(): self {
        $this->statement .= " OR ";

        return $this;
    }

    public function join(string $type, string $table, string $column): self {
        $this->statement .= " ${type} JOIN " . $table . ' USING (' . $column . ')';

        return $this; 
    }

    public function first(): array {
        try {
            return $this->result->fetch();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function all(): array {
        try {
            return $this->result->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getStatement(): string {
        return $this->statement;
    }

    public function execute(): self {
        $this->statement .= ';';

        try {
            $this->result = $this->database->getConnection()->query($this->statement);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
       }

        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}