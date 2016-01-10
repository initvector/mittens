<?php

namespace Initvector\Mittens;

/**
 * @license http://opensource.org/licenses/MIT MIT License
 */
class EndpointGroup {

    protected $gitHubClient;

    public function __construct(\Initvector\Mittens\GitHubClient $gitHubClient) {
        $this->gitHubClient = $gitHubClient;
    }
}
