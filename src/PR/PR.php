<?php
namespace Initvector\Mittens\PR;
use Initvector\Mittens\EndpointGroup;

/**
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://developer.github.com/v3/repos/
 * @package Initvector\Mittens
 */
class PR extends EndpointGroup {

    /**
     * @link https://developer.github.com/v3/pulls/#list-pull-requests
     * @param string $owner
     * @param string $repo
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getByRepo($owner, $repo, array $options = [], $page = 1) {
        $optionDefaults = [
            'base'      => null,
            'direction' => 'desc',
            'head'      => null,
            'sort'      => 'created',
            'state'     => 'open'
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/pulls",
            $options,
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#get-a-single-pull-request
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function get($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}"
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#list-commits-on-a-pull-request
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function getCommits($owner, $repo, $number, $page = 1) {
        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/pulls/{$number}/commits",
            [],
            $page
        );
    }


    /**
     * @link https://developer.github.com/v3/pulls/#list-pull-requests-files
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function getFiles($owner, $repo, $number, $page = 1) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}/files",
            [],
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#get-if-a-pull-request-has-been-merged
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function isMerged($owner, $repo, $number) {
        /**
         * If the PR has not been merged, it'll return a 404.  This could possibly cause our HttpClient to throw an
         * exception without any real error being reached.  To avoid that, we grab the current "throw" setting, disable
         * throwing exceptions, perform the request and then restore the original "throw" setting.
         */
        $throwExceptions = $this->gitHubClient->getThrowExceptions();
        $this->gitHubClient->setThrowExceptions(false);
        $result = $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}/merge"
        );
        $this->gitHubClient->setThrowExceptions($throwExceptions);

        return $result;
    }
}
