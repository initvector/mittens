<?php
/**
 * @license http://opensource.org/licenses/MIT MIT License
 */
namespace Initvector\Mittens;

class Client {

    private $gitHubClient;

    private $issue;

    private $pr;

    private $repo;

    const VERSION = '0.4.2';

    public function __construct($accessToken, $throwExceptions = true) {
        $gitHubClient = new GitHubClient($accessToken);
        $gitHubClient->setThrowExceptions($throwExceptions);

        $this->issue = new Issue\Issue($gitHubClient);
        $this->pr = new PR\PR($gitHubClient);
        $this->repo = new Repo\Repo($gitHubClient);

        $this->gitHubClient = $gitHubClient;
    }

    public function issue() {
        return $this->issue;
    }

    public function pr() {
        return $this->pr;
    }

    public function repo() {
        return $this->repo;
    }
}
