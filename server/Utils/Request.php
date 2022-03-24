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

    public function populateUrlSegments(): Request {
        [
            'path' => $this->path,
            'query' =>  $query
        ] = parse_url($this->requestUri);

        parse_str($query, $this->queries);

        print_r($this->path);
        print_r($this->queries);

        return $this;
    }

    public function populatePayload(): Request {
        if ($this->requestMethod === 'GET') {
            $this->payload = $_GET;
        } else if ($this->requestMethod === 'POST') {
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
        }

        return $this;
    }
}