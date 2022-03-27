<?php

declare(strict_types = 1);

namespace App\Database;

class Table {
    private string $statement;

    /**
     * @param array $fields = [
     *      [
     *          'name' => '',
     *          'data_type' => '',
     *          'constraints' => ['' [, ...] ],
     *      ]
     * ]
     * @param array|null $index = ['index_name' => '', 'columns' => ['' [, ...] ] ]
     */
    public function __construct(
        private Database $database,
        private string $name,
        private array $fields,
        private array|null $index = null
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

        if ($this->index !== null) {
            $this->statement .=
                ', INDEX ' . $this->index['index_name'] . ' (' . implode(', ', $this->index['columns']) . ')';
        }

        $this->statement .= ');';

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