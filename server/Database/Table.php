<?php

declare(strict_types = 1);

namespace App\Database;

class Table {
    private string $statement;

    public function __construct(
        private Database $database,
        private string $name,
        private array $fields
    ) {
    }

    public function build(): self {
        $this->statement = 'CREATE TABLE IF NOT EXISTS ' . $this->name . ' (';

        $i = 0;
        $size = count($this->fields);

        foreach ($this->fields as $field) {
            $this->statement .= 
                $field['name'] . ' ' . $field['data_type'] . ' ' . implode(' ', $field['constraints']);
            
            if (++$i !== $size)
                $this->statement .= ', ';
        }

        $this->statement .= ');';

        return $this;
    }

    public function create(): self {
        $this->database->getConnection()->exec($this->statement);

        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStatement(): string {
        return $this->statement;
    }
}