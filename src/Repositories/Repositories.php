<?php
namespace Initvector\Mittens\Repositories;
use Initvector\Mittens\EndpointGroup;

/**
 * @package Initvector\Mittens\Repositories
 * @link https://developer.github.com/v3/repos/
 */
class Repositories extends EndpointGroup {

    /**
     * List repositories that are accessible to the authenticated user.
     *
     * This includes repositories owned by the authenticated user, repositories where the authenticated user is a
     * collaborator, and repositories that the authenticated user has access to through an organization membership.
     *
     * @link https://developer.github.com/v3/repos/#list-your-repositories
     * @link https://developer.github.com/v3/#pagination
     * @param string visibility Can be one of all, public, or private.
     * @param string affiliation Comma-separated list of values. Can include: owner - Repositories that are owned by the
     *   authenticated user, collaborator - Repositories that the user has been added to as a collaborator,
     *   organization_member - Repositories that the user has access to through being a member of an organization. This
     *   includes every repository on every team that the user is on.
     * @param string sort Can be one of created, updated, pushed, full_name.
     * @param string direction Can be one of asc or desc.
     * @return \Garden\Http\HttpResponse
     */
    public function listYourRepositories($visibility = 'all', $affiliation = 'owner,collaborator,organization_member', $sort = 'full_name', $direction = 'asc') {
        return $this->gitHubClient->get(
            "/user/repos",
            [
                'affiliation' => $affiliation,
                'direction'   => $direction,
                'sort'        => $sort,
                'visibility'  => $visibility
            ]
        );
    }

    /**
     * List public repositories for the specified user.
     *
     * @link https://developer.github.com/v3/repos/#list-user-repositories
     * @link https://developer.github.com/v3/#pagination
     * @param string $username
     * @param string $type Can be one of all, owner, member.
     * @param string $sort Can be one of created, updated, pushed, full_name.
     * @param string $direction Can be one of asc or desc.
     * @return \Garden\Http\HttpResponse
     */
    public function listUserRepositories($username, $type = 'owner', $sort = 'full_name', $direction = 'asc') {
        return $this->gitHubClient->get(
            "/users/{$username}/repos",
            [
                'type'      => $type,
                'sort'      => $sort,
                'direction' => $direction
            ]
        );
    }

    /**
     * List repositories for the specified org.
     *
     * @link https://developer.github.com/v3/repos/#list-organization-repositories
     * @link https://developer.github.com/v3/#pagination
     * @param string $org
     * @param string $type Can be one of all, public, private, forks, sources, member.
     * @return \Garden\Http\HttpResponse
     */
    public function listOrganizationRepositories($org, $type = 'all') {
        $query = [
            'type' => $type
        ];

        return $this->gitHubClient->get(
            "/orgs/:org/repos",
            $query
        );
    }

    /**
     * This provides a dump of every public repository, in the order that they were created.
     *
     * @link https://developer.github.com/v3/repos/#list-all-public-repositories
     * @link https://developer.github.com/v3/#pagination
     * @param string $since The integer ID of the last Repository that you've seen.
     * @return \Garden\Http\HttpResponse
     */
    public function listAllPublicRepositories($since) {
        $query = [];

        if (!empty($since)) {
            $query['since'] = $since;
        }

        return $this->gitHubClient->get(
            "/repositories",
            $query
        );
    }

    /**
     *
     * @link https://developer.github.com/v3/repos/#get
     * @param $owner
     * @param $repo
     * @return \Garden\Http\HttpResponse
     */
    public function get($owner, $repo) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}"
        );
    }

    /**
     * List contributors to the specified repository, sorted by the number of commits per contributor in descending
     * order.
     *
     * @link https://developer.github.com/v3/repos/#list-contributors
     * @link https://developer.github.com/v3/#pagination
     * @param $owner
     * @param $repo
     * @param string $anon Set to 1 or true to include anonymous contributors in results.
     * @return \Garden\Http\HttpResponse
     */
    public function listContributors($owner, $repo, $anon = 0) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/contributors"
        );
    }

    /**
     * List languages for the specified repository. The value on the right of a language is the number of bytes of code
     * written in that language.
     *
     * @link https://developer.github.com/v3/repos/#list-languages
     * @link https://developer.github.com/v3/#pagination
     * @param $owner
     * @param $repo
     * @return \Garden\Http\HttpResponse
     */
    public function listLanguages($owner, $repo) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/languages"
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-teams
     * @link https://developer.github.com/v3/#pagination
     * @param $owner
     * @param $repo
     * @return \Garden\Http\HttpResponse
     */
    public function listTeams($owner, $repo) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/teams"
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-tags
     * @link https://developer.github.com/v3/#pagination
     * @param $owner
     * @param $repo
     * @return \Garden\Http\HttpResponse
     */
    public function listTags($owner, $repo) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/tags"
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-branches
     * @link https://developer.github.com/v3/#pagination
     * @param string $owner
     * @param string $repo
     * @param string $protected Set to 1 or true to only return protected branches.
     * @return \Garden\Http\HttpResponse
     */
    public function listBranches($owner, $repo, $protected = 0) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/branches",
            [
                'protected' => $protected
            ]
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#get-branch
     * @param $owner
     * @param $repo
     * @param $branch
     * @return \Garden\Http\HttpResponse
     */
    public function getBranch($owner, $repo, $branch) {
        return $this->gitHubClient->get(
            "/repos/{$owner}/{$repo}/branches/{$branch}"
        );
    }
}
