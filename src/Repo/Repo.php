<?php
namespace Initvector\Mittens\Repo;
use Initvector\Mittens\EndpointGroup;

/**
 * @package Initvector\Mittens
 * @link https://developer.github.com/v3/repos/
 */
class Repo extends EndpointGroup {

    /**
     * List repositories that are accessible to the authenticated user.
     *
     * This includes repositories owned by the authenticated user, repositories where the authenticated user is a
     * collaborator, and repositories that the authenticated user has access to through an organization membership.
     *
     * @link https://developer.github.com/v3/repos/#list-your-repositories
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getOwn(array $options = [], $page = 1) {
        $optionDefaults = [
            'affiliation' => 'owner,collaborator,organization_member',
            'direction'   => 'asc',
            'sort'        => 'full_name',
            'visibility'  => 'all'
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/user/repos",
            $options,
            $page
        );
    }

    /**
     * List public repositories for the specified user.
     *
     * @link https://developer.github.com/v3/repos/#list-user-repositories
     * @param string $username
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getByUser($username, array $options = [], $page = 1) {
        $optionDefaults = [
            'direction' => 'asc',
            'sort'      => 'full_name',
            'type'      => 'owner'
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/users/{$username}/repos",
            $options,
            $page
        );
    }

    /**
     * List repositories for the specified org.
     *
     * @link https://developer.github.com/v3/repos/#list-organization-repositories
     * @param string $org
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getByOrganization($org, array $options = [], $page = 1) {
        $optionDefaults = [
            'type' => 'all'
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/orgs/{$org}/repos",
            $options,
            $page
        );
    }

    /**
     * This provides a dump of every public repository, in the order that they were created.
     *
     * @link https://developer.github.com/v3/repos/#list-all-public-repositories
     * @param string $since The integer ID of the last Repository that you've seen.
     * @return \Garden\Http\HttpResponse
     */
    public function getPublicRepos($since, array $options = [], $page = 1) {
        $optionDefaults = [
            'since' => null
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/repositories",
            $options,
            $page
        );
    }

    /**
     *
     * @link https://developer.github.com/v3/repos/#get
     * @param string $owner
     * @param string $repo
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
     * @param string $owner
     * @param string $repo
     * @param array $options
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getContributors($owner, $repo, array $options = [], $page = 1) {
        $optionDefaults = [
            'anon' => null
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/contributors",
            $options,
            $page
        );
    }

    /**
     * List languages for the specified repository. The value on the right of a language is the number of bytes of code
     * written in that language.
     *
     * @link https://developer.github.com/v3/repos/#list-languages
     * @param string $owner
     * @param string $repo
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getLanguages($owner, $repo, $page = 1) {
        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/languages",
            [],
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-teams
     * @param string $owner
     * @param string $repo
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getTeams($owner, $repo, $page = 1) {
        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/teams",
            [],
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-tags
     * @param string $owner
     * @param string $repo
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getTags($owner, $repo, $page = 1) {
        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/tags",
            [],
            $page
        );
    }

    /**
     * @link https://developer.github.com/v3/repos/#list-branches
     * @param string $owner
     * @param string $repo
     * @param int $page
     * @return \Garden\Http\HttpResponse
     */
    public function getBranches($owner, $repo, array $options = [], $page = 1) {
        $optionDefaults = [
            'protected' => 0
        ];

        $options = array_merge($optionDefaults, $options);

        return $this->gitHubClient->getPage(
            "/repos/{$owner}/{$repo}/branches",
            $options,
            $page
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
