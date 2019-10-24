# iammordaty/guzzle-urlencoded-response-middleware

Simple Guzzle 6.x URL-encoded response middleware.

## Installation

```bash
$ composer require iammordaty/guzzle-urlencoded-response-middleware
```

## Requirements

* PHP 7.1

## Sample usage

```php
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleUrlEncodedResponseMiddleware\UrlEncodedResponseMiddleware;
use function GuzzleHttp\Psr7\stream_for;

$body = 'id=78349&name=John%20Smith&username=%40smith&email=hello%40smith.com&phone=%2B1-202-555-0192&website=smith.dev';

// IRL: fetch data from server
$mock = new MockHandler([
    (new Response())->withBody(stream_for($body))
]);

$stack = HandlerStack::create($mock);
$stack->push(new UrlEncodedResponseMiddleware(), UrlEncodedResponseMiddleware::NAME);

$client = new Client([ 'handler' => $stack ]);

$response = $client->get('/');
$contents = $response->getBody()->getUrlDecodedParsedContents();

print_r($contents);

/*
Outputs:

Array
(
    [id] => 78349
    [name] => John Smith
    [username] => @smith
    [email] => hello@smith.com
    [phone] => +1-202-555-0192
    [website] => smith.dev
)
*/

$response->getBody()->rewind();

echo $response->getBody()->getUrlDecodedContents();

// Outputs: id=78349&name=John Smith&username=@smith&email=hello@smith.com&phone=+1-202-555-0192&website=smith.dev

```

## License

iammordaty/guzzle-urlencoded-response-middleware is licensed under the MIT License.
