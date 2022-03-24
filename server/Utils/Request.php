<?php

namespace App\Utils;

class Request {
    private array $payload;

    private string $path;

    private array $queries;

    public function __construct(
        private string $requestUri,
        private string $requestMethod,
        private string $contentType
    ) {
        $this->payload = [];
        $this->queries = [];
    }

    public function populateUrlSegments(): self {
        if (parse_url($this->requestUri, PHP_URL_QUERY)) {
            ['query' => $query] = parse_url($this->requestUri);
            parse_str($query, $this->queries);
        }

        ['path' => $this->path] = parse_url($this->requestUri);

        return $this;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getQueries(): array {
        return $this->queries;
    }

    public function populatePayload(): self {
        switch ($this->requestMethod) {
            case 'GET':
                $this->payload = $_GET;
                break;
            case 'DELETE':
            case 'POST':
                if (preg_match("#application/json#", $this->contentType)) {
                    $json = file_get_contents('php://input');

                    $this->payload = json_decode($json);
                } else if (
                    preg_match("#application/x-www-form-urlencoded#", $this->contentType)
                    ||
                    preg_match("#multipart/form-data#", $this->contentType)
                ) {
                    $this->payload = $_POST;
                }

                break;
        }

        return $this;
    }

    public function getPayload(): array {
        return $this->payload;
    }

    public function getMethod(): string {
        return $this->requestMethod;
    }

    public function getUri(): string {
        return $this->requestUri;
    }
}