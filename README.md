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

## Convenience Methods
`Initvector\Mittens\GitHubData` contains a few functions to simplify the extraction of key data from GitHub API responses.  These functions are:

* `getEtag` - Grabs the entity tag from a response and returns it, along with a strong/weak flag.
* `getPagination` - Breaks the `Link` header returned by API requests to extract the following pagination data: first page, last page, next page and previous page.
* `getRateLimit` - Will parse the `X-RateLimit-*` headers to determine the account limit, remaining requests until the limit is reached and a timestamp of when the limit will be reset.

## Example Usage
```php
// Grab the first page of results of all repos the current API user is associated with
use Initvector\Mittens\Client as mittens;

$mittens = new mittens('authentication-token-goes-here');
$result = $client->repo()->getOwn()->getBody();
```

Now `$result` contains the response body from GitHub's [List Your Repos](https://developer.github.com/v3/repos/#list-your-repositories) endpoint _as an array_.

## Usage Notes
* API requests will return an `Garden\Http\HttpResponse` object representing the full state of the HTTP response.  This object can be used to pull raw header or body contents.
* Use `getBody` to retrieve the data and convert from JSON to an array, if possible.
