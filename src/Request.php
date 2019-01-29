<?php

namespace KielD01\InstaTag;

use Exception;
use GuzzleHttp\Client;
use phpQuery;
use Psr\Http\Message\ResponseInterface;

class Request
{

    CONST USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';

    /**
     * @return Client
     */
    private static function init()
    {
        return new Client([
            'cookies' => true,
            'headers' => [
                'user-agent' => Request::USER_AGENT
            ]
        ]);
    }

    /**
     * @param ResponseInterface $response
     * @return \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     */
    private static function parseBody(ResponseInterface $response)
    {
        return phpQuery::newDocumentHTML($response->getBody()->getContents());
    }

    /**
     * @param null|string $url
     * @return \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     * @throws Exception
     */
    public static function get($url = null)
    {
        if (!$url) {
            throw new Exception('$url cannot be null');
        }

        $client = self::init();

        return self::parseBody($client->get($url));
    }
}