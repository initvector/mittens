<?php
namespace Initvector\Mittens;

class EndpointGroup {

    protected $gitHubClient;

    public function __construct(\Initvector\Mittens\GitHubClient $gitHubClient) {
        $this->gitHubClient = $gitHubClient;
    }
}
