<?php
namespace Initvector\Mittens\Issue;
use Initvector\Mittens\EndpointGroup;

/**
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://developer.github.com/v3/issues/
 * @package Initvector\Mittens
 */
class Issue extends EndpointGroup {

    /**
     * @link https://developer.github.com/v3/issues/#list-issues-for-a-repository
     * @param string $owner
     * @param string $repo
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getByRepo($owner, $repo, array $options = [], $page = 1) {
        $optionDefaults = [
            'state'     => 'open',
            'sort'      => 'created',
            'direction' => 'desc',
            'since'     => null,
            'creator'   => null,
            'assignee'  => null,
            'labels'    => null,
            'milestone' => null,
            'mentioned' => null
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/issues",
            $options,
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/issues/#get-a-single-issue
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function get($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/issues/{$number}"
        );
    }
}
