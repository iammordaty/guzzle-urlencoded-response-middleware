<?php

namespace GuzzleUrlEncodedResponseMiddleware;

use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;

class UrlEncodedStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * Returns URL-encoded body contents as decoded URL-encoded string
     *
     * @param int|bool $urlEncoding
     * @return string
     */
    public function getUrlDecodedContents($urlEncoding = true): string
    {
        $params = $this->getUrlDecodedParsedContents($urlEncoding);
        $result = build_query($params, false);

        return $result;
    }

    /**
     * Returns URL-encoded body contents as associative array
     *
     * @param int|bool $urlEncoding How the query string is encoded
     * @return array
     */
    public function getUrlDecodedParsedContents($urlEncoding = true): array
    {
        $contents = $this->getContents();
        $result = parse_query($contents, $urlEncoding);

        return $result;
    }
}
