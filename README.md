# Mittens
A read-only library for accessing [version 3 of GitHub's API](https://developer.github.com/v3/) and driven by [Garden HTTP](https://github.com/vanilla/garden-http).

## Currently Supported
* Issues
  * [Get a single issue](https://developer.github.com/v3/issues/#get-a-single-issue)
  * [List issues for a repository](https://developer.github.com/v3/issues/#list-issues-for-a-repository)
* Pull Requests
  * [Get a single pull request](https://developer.github.com/v3/pulls/#get-a-single-pull-request)
  * [List pull requests](https://developer.github.com/v3/pulls/#list-pull-requests)
  * [List commits on a pull request](https://developer.github.com/v3/pulls/#list-commits-on-a-pull-request)
  * [List pull requests files](https://developer.github.com/v3/pulls/#list-pull-requests-files)
  * [Get if a pull request has been merged](https://developer.github.com/v3/pulls/#get-if-a-pull-request-has-been-merged)
* Repositories
  * [Get](https://developer.github.com/v3/repos/#get)
  * [List your repositories](https://developer.github.com/v3/repos/#list-your-repositories)
  * [List user repositories](https://developer.github.com/v3/repos/#list-user-repositories)
  * [List organization repositories](https://developer.github.com/v3/repos/#list-organization-repositories)
  * [List all public repositories](https://developer.github.com/v3/repos/#list-all-public-repositories)
  * [List contributors](https://developer.github.com/v3/repos/#list-contributors)
  * [List teams](https://developer.github.com/v3/repos/#list-teams)
  * [List tags](https://developer.github.com/v3/repos/#list-tags)
  * [List branches](https://developer.github.com/v3/repos/#list-branches)
  * [Get branch](https://developer.github.com/v3/repos/#get-branch)
  * [List languages](https://developer.github.com/v3/repos/#list-languages)

## Example Usage
```php
// Grab the first page of results of all repos the current API user is associated with
$mittens = new Initvector\Mittens\Client('authentication-token-goes-here');
$result = $client->repo()->getOwn()->getBody();
```
