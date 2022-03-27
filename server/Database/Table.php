<?php

declare(strict_types = 1);

namespace App\Database;

class Table {
    private string $statement;

    private array $fields;

    private array $foreignKeys;

    private string $index;

    public function __construct(
        private Database $database,
        private string $name,
    ) {
        $this->fields = [];
        $this->foreignKeys = [];
        $this->index = '';
    }

    public function addField(string $name, string $dataType, array $constraints): self {
        $this->fields[] = 
            $name . ' ' . $dataType . ' ' . implode(' ', $constraints);

        return $this;
    }

    public function addForeignKey(
        string $name,
        array $columns,
        string $reference,
        array $referenceColumns,
        string $onDelete = '',
        string $onUpdate = ''
    ): self {
        $this->foreignKeys[] = 
            'FOREIGN KEY ' . $name
                . ' (' . implode(', ', $columns) . ') '
            . 'REFERENCES ' . $reference . ' ('
                . implode(', ', $referenceColumns) . ') '
            . ( ($onDelete !== '') ? 'ON DELETE ' . $onDelete : '' )
            . ( ($onUpdate !== '') ? 'ON UPDATE ' . $onUpdate : '' );
            
        return $this;
    }

    public function addIndex(string $name, array $columns): self {
        $this->index =
            'INDEX ' . $name . ' (' . implode(', ', $columns) . ')';

        return $this;
    }

    public function build(): self {
        $this->statement = 
            'CREATE TABLE IF NOT EXISTS ' . $this->name . ' ('
            . implode(', ', $this->fields)
            . ( !( empty($this->foreignKeys) ) ? ', ' . implode(', ', $this->foreignKeys) : '' )
            . ( ($this->index !== '') ? ', ' . $this->index : '' )
            . ');';

        return $this;
    }

    public function create(): self {
        try {
            $this->database->getConnection()->exec($this->statement);
        } catch (\PDOException $e) {
           throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStatement(): string {
        return $this->statement;
    }
}