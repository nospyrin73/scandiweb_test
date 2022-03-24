<?php

declare(strict_types = 1);

namespace App;

class Response {
    public function type(string $contentType): self {
        header("Content-Type: ${contentType}");

        return $this;
    }

    public function status(int $code): self {
        http_response_code($code);

        return $this;
    }

    public function send($data): void {
        echo $data;

        $this->end();
    }

    public function sendFile($path): void {
        if (file_exists($path))
            echo include $path;

        $this->end();
    }
    
    public function json(string|array|object $data): void {
        echo json_encode($data);

        $this->end();
    }

    public function end(): void {
        die();
    }
}