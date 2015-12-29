<?php
namespace Initvector\Mittens;

class Client {

    private $gitHubClient;

    private $issues;

    private $pullRequests;

    private $repositories;

    public function __construct($accessToken, $throwExceptions = true) {
        $gitHubClient = new GitHubClient($accessToken);
        $gitHubClient->setThrowExceptions($throwExceptions);

        $this->issues = new Issues\Issues($gitHubClient);
        $this->pullRequests = new PullRequests\PullRequests($gitHubClient);
        $this->repositories = new Repositories\Repositories($gitHubClient);

        $this->gitHubClient = $gitHubClient;
    }

    public function issues() {
        return $this->issues;
    }

    public function pullRequests() {
        return $this->pullRequests;
    }

    public function repositories() {
        return $this->repositories;
    }
}
