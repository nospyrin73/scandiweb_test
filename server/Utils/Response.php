<?php

declare(strict_types = 1);

namespace App\Utils;

class Response {
    public function type(string $path): self {
        if (file_exists($path))
            header("Content-Type: {mime_content_type($path)}");

        return $this;
    }

    public function status(int $code, string $message = ''): self {
        header("HTTP/1.1 ${code} ${message}");

        return $this;
    }

    public function send($data): void {
        echo $data;

        $this->end();
    }

    public function sendFile($path): void {
        if (file_exists($path))
            echo file_get_contents($path);

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