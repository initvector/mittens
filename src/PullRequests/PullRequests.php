<?php
namespace Initvector\Mittens\PullRequests;
use Initvector\Mittens\EndpointGroup;

class PullRequests extends EndpointGroup {

    /**
     * @link https://developer.github.com/v3/pulls/#list-pull-requests
     * @link https://developer.github.com/v3/#pagination
     * @param string $owner
     * @param string $repo
     * @param string $state Either open, closed, or all to filter by state.
     * @param string $sort What to sort results by. Can be either created, updated, popularity (comment count) or
     *   long-running (age, filtering by pulls updated in the last month).
     * @param string $direction The direction of the sort. Can be either asc or desc.
     * @param string $base Filter pulls by base branch name.
     * @param string $head Filter pulls by head user and branch name in the format of user:ref-name.
     * @return \Garden\Http\HttpResponse
     */
    public function listPullRequests($owner, $repo, $state = 'open', $sort = 'created', $direction = 'desc', $base = null, $head = null) {
        $query = [
            'state'     => $state,
            'sort'      => $sort,
            'direction' => $direction
        ];

        if (!empty($base)) {
            $query['base'] = $base;
        }
        if (!empty($head)) {
            $query['head'] = $head;
        }

        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls",
            $query
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#get-a-single-pull-request
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function getASinglePullRequest($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}"
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#list-commits-on-a-pull-request
     * @link https://developer.github.com/v3/#pagination
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function listCommitsOnAPullRequest($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}/commits"
        );
    }


    /**
     * @link https://developer.github.com/v3/pulls/#list-pull-requests-files
     * @link https://developer.github.com/v3/#pagination
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function listPullRequestsFiles($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}/files"
        );
    }

    /**
     * @link https://developer.github.com/v3/pulls/#get-if-a-pull-request-has-been-merged
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function getIfAPullRequestHasBeenMerged($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/pulls/{$number}/merge"
        );
    }
}
