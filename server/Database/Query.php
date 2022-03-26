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

    public function insert(array $data): self {
        $this->statement = 
            'INSERT INTO ' . $this->table->getName() . ' (' . implode(', ', array_keys($data)) . ') ' .
            'VALUES (' . implode(', ', array_values($data)) . ')';
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

    public function getStatement(): string {
        return $this->statement;
    }

    public function execute(): self {
        $this->statement .= ';';

        $this->result = $this->database->getConnection()->query($this->statement);

        return $this;
    }

    public function getResult() {
        return $this->result;
    }
}