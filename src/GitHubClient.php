<?php
namespace Initvector\Mittens;
use Garden\Http\HttpClient;

class GitHubClient extends HttpClient {

    public function __construct($accessToken) {
        parent::__construct('https://api.github.com');

        $this->setDefaultHeader('Accept', 'application/vnd.github.v3+json');
        $this->setDefaultHeader('Authorization', "token {$accessToken}");
        $this->setDefaultHeader('Content-Type', 'application/json');
    }
}
