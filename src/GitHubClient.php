<?php
namespace Initvector\Mittens;
use Garden\Http\HttpClient;

class GitHubClient extends HttpClient {

    private $perPage = 100;

    public function __construct($accessToken) {
        parent::__construct('https://api.github.com');

        $this->setDefaultHeader('Accept', 'application/vnd.github.v3+json');
        $this->setDefaultHeader('Authorization', "token {$accessToken}");
        $this->setDefaultHeader('Content-Type', 'application/json');
    }

    /**
     * Automatically append page number to the provided GET request
     *
     * @param string $uri
     * @param array $query
     * @param array $headers
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getPage($uri, array $query, array $headers, array $options, $page = 1) {
        $uri = static::appendQuery(
            $uri,
            [
                'page' => $page
            ]
        );

        return parent::get($uri, $query, $headers, $options);
    }

    /**
     * Set or get the current per_page value
     *
     * @param bool $resultsPerPage
     * @return int
     */
    public function perPage($resultsPerPage = false) {
        if ($resultsPerPage) {
            $this->perPage = $resultsPerPage;
        }

        return $this->perPage;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|string $body
     * @param array $headers
     * @param array $options
     * @return \Garden\Http\HttpResponse
     */
    public function request($method, $uri, $body, $headers = [], array $options = []) {
        // Automatically insert per_page for all API requests
        $uri = static::appendQuery(
            $uri,
            [
                'per_page' => $this->perPage()
            ]
        );

        return parent::request($method, $uri, $body, $headers, $options);
    }
}
