<?php
namespace Initvector\Mittens\Issues;
use Initvector\Mittens\EndpointGroup;

class Issues extends EndpointGroup {

    /**
     * @link https://developer.github.com/v3/issues/#list-issues-for-a-repository
     * @link https://developer.github.com/v3/#pagination
     * @param $owner
     * @param $repo
     * @param string $state Indicates the state of the issues to return. Can be either open, closed, or all.
     * @param string $sort What to sort results by. Can be either created, updated, comments.
     * @param string $direction The direction of the sort. Can be either asc or desc.
     * @param string $since Only issues updated at or after this time are returned. This is a timestamp in ISO 8601
     *   format: YYYY-MM-DDTHH:MM:SSZ.
     * @param string $creator The user that created the issue.
     * @param string $assignee Can be the name of a user. Pass in none for issues with no assigned user, and * for
     *   issues assigned to any user.
     * @param string $labels A list of comma separated label names.
     * @param string $milestone If an integer is passed, it should refer to a milestone by its number field. If the
     *   string * is passed, issues with any milestone are accepted. If the string none is passed, issues without
     *   milestones are returned.
     * @param string $mentioned A user that's mentioned in the issue.
     * @return \Garden\Http\HttpResponse
     */
    public function listIssuesForARepository($owner, $repo, $state = 'open', $sort = 'created', $direction = 'desc', $since = null, $creator = null, $assignee = null, $labels = null, $milestone = null, $mentioned = null) {
        $query = [
            'state'     => $state,
            'sort'      => $sort,
            'direction' => $direction
        ];

        if (!empty($since)) {
            $query['since'] = $since;
        }
        if (!empty($creator)) {
            $query['creator'] = $creator;
        }
        if (!empty($assignee)) {
            $query['assignee'] = $assignee;
        }
        if (!empty($labels)) {
            $query['labels'] = $labels;
        }
        if (!empty($milestone)) {
            $query['milestone'] = $milestone;
        }
        if (!empty($mentioned)) {
            $query['mentioned'] = $mentioned;
        }

        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/issues",
            $query
        );
    }

    /**
     * @link https://developer.github.com/v3/issues/#get-a-single-issue
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return \Garden\Http\HttpResponse
     */
    public function getASingleIssue($owner, $repo, $number) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/issues/{$number}"
        );
    }
}
