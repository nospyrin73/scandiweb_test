<?php

declare(strict_types = 1);

namespace App\Utils;

class Response {
    public function type(string $path): self {
        if (file_exists($path)) {
            $detector = new \League\MimeTypeDetection\FinfoMimeTypeDetector();
            $mimeType = $detector->detectMimeType($path, 'string contents');
            
            header("Content-Type: ${mimeType}");
        }

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
        header('Content-Type: application/json');
        echo json_encode($data);

        $this->end();
    }

    public function end(): void {
        die();
    }
}