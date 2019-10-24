<?php

namespace GuzzleUrlEncodedResponseMiddleware;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UrlEncodedResponseMiddleware
{
    public const NAME = 'guzzle-urlencoded-response-middleware';

    public function __invoke(callable $handler): Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            /** @var PromiseInterface $promise */
            $promise = $handler($request, $options);

            return $promise->then(function (ResponseInterface $response) {
                $body = new UrlEncodedStream($response->getBody());

                return $response->withBody($body);
            });
        };
    }
}
