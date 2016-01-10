<?php
namespace Initvector\Mittens;

class GitHubData {

    /**
     * Fetch entity tag information from the ETag header, if available.
     *
     * @param \Garden\Http\HttpResponse $response
     * @return null|string
     */
    public static function getEtag(\Garden\Http\HttpResponse $response) {
        $etag = [
            'strong' => false,
            'tag'    => null
        ];

        if ($response->isSuccessful()) {
            if ($raw = $response->getHeader('ETag')) {
                if (preg_match('#(?P<weak>W\/)?"(?P<tag>[A-za-z0-9]+)"#', $raw, $tagParts)) {
                    if (empty($tagParts['weak'])) {
                        $etag['strong'] = true;
                    }

                    $etag['tag'] = $tagParts['tag'];
                }
            }
        }

        return $etag;
    }

    /**
     * Extract GitHub's pagination information from the Link header of a Garden HTTP HttpResponse object
     *
     * @link https://developer.github.com/v3/#pagination
     * @param \Garden\Http\HttpResponse $response
     * @return array
     */
    public static function getPagination(\Garden\Http\HttpResponse $response) {
        $pages = [
            'first' => null,
            'last'  => null,
            'next'  => null,
            'prev'  => null
        ];

        if ($response->isSuccessful()) {
            if ($link = $response->getHeader('Link')) {
                $pagePattern = '`<https?:\/\/[A-Z0-9\-\._~:\/?#\[\]@!$&\'()*+,;=]+[?&]page=(?P<page>\d+)[A-Z0-9\-\._~:\/?#\[\]@!$&\'()*+,;=]+>; rel="(?P<rel>first|prev|next|last)`i';
                if (preg_match_all($pagePattern, $link, $pageMatches)) {
                    foreach ($pageMatches['rel'] as $relIndex => $relVal) {
                        $pages[$relVal] = $pageMatches['page'][$relIndex];
                    }
                }
            }
        }

        return $pages;
    }

    /**
     * Grab the rate limitation information from a response
     *
     * @param \Garden\Http\HttpResponse $response
     * @return array
     */
    public static function getRateLimit(\Garden\Http\HttpResponse $response) {
        $rateLimit = [
            'limit'     => null,
            'remaining' => null,
            'reset'     => null
        ];

        /**
         * Only attempt to fetch headers on a successful request.  Only attempt to overwrite our defaults if the
         * header is set.
         */
        if ($response->isSuccessful()) {
            if ($limit = $response->getHeader('X-RateLimit-Limit')) {
                $rateLimit['limit'] = $limit;
            }
            if ($remaining = $response->getHeader('X-RateLimit-Remaining')) {
                $rateLimit['remaining'] = $remaining;
            }
            if ($reset = $response->getHeader('X-RateLimit-Reset')) {
                $rateLimit['reset'] = $reset;
            }
        }

        return $rateLimit;
    }
}
