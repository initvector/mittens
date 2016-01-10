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
        $this->setDefaultHeader('User-Agent', 'mittens/' . Client::VERSION . ' (https://github.com/initvector/mittens)');
    }

    /**
     * @param string $uri
     * @param array $query
     * @param array $headers
     * @param array $options
     * @return \Garden\Http\HttpResponse
     */
    public function get($uri, array $query = [], array $headers = [], $options = []) {
        foreach ($query as $name => $value) {
            if ($value === null) {
                unset($query[$name]);
            }
        }

        return parent::get($uri, $query, $headers, $options);
    }

    /**
     * Automatically append page number to the provided GET request
     *
     * @param string $uri
     * @param array $query
     * @param int $page
     * @param array $headers
     * @param array $options
     * @return \Garden\Http\HttpResponse
     */
    public function getPage($uri, array $query, $page = 1, array $headers = [], array $options = []) {
        $uri = static::appendQuery(
            $uri,
            [
                'page' => $page,
                'per_page' => $this->perPage()
            ]
        );

        return $this->get($uri, $query, $headers, $options);
    }

    /**
     * Extract GitHub's pagination information from the Link header of a Garden HTTP HttpResponse object
     *
     * @link https://developer.github.com/v3/#pagination
     * @param \Garden\Http\HttpResponse $response
     * @return array
     */
    public static function getPagination(\Garden\Http\HttpResponse $response) {
        $pages = [
            'first' => null,
            'last'  => null,
            'next'  => null,
            'prev'  => null
        ];

        if ($response->isSuccessful()) {
            if ($link = $response->getHeader('Link')) {
                $pagePattern = '`<https?:\/\/[A-Z0-9\-\._~:\/?#\[\]@!$&\'()*+,;=]+[?&]page=(?P<page>\d+)[A-Z0-9\-\._~:\/?#\[\]@!$&\'()*+,;=]+>; rel="(?P<rel>first|prev|next|last)`i';
                if (preg_match_all($pagePattern, $link, $pageMatches)) {
                    foreach ($pageMatches['rel'] as $relIndex => $relVal) {
                        $pages[$relVal] = $pageMatches['page'][$relIndex];
                    }
                }
            }
        }

        return $pages;
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
}
