<?php

namespace KielD01\InstaTag;

use Exception;
use KielD01\InstaTag\Models\Post;
use phpQueryObject;

/**
 * Class Search
 * @package KielD01\InstaTag\Request
 */
class Search
{

    /**
     * @param null|string $hashTag
     * @return Post[]
     * @throws Exception
     */
    public static function byHashTag($hashTag = null)
    {
        if (!$hashTag) {
            throw new Exception('$hashTag cannot be empty');
        }

        $url = str_replace('{hashTag}', $hashTag, 'https://www.instagram.com/explore/tags/{hashTag}/');
        $sharedData = self::parseScriptData(Request::get($url));

        if (!$sharedData) {
            throw new Exception('$sharedData cannot be null');
        }

        $edges = current($sharedData['entry_data']['TagPage'])['graphql']['hashtag']['edge_hashtag_to_top_posts']['edges'];
        $posts = [];

        foreach ($edges as $edge) {
            $post = new Post();
            $edge = $edge['node'];

            $post->setAttribute('url', "https://www.instagram.com/p/{$edge['shortcode']}/");
            $post->setAttribute('image', $edge['thumbnail_src']);

            $posts[] = $post;
        }

        return $posts;
    }

    /**
     * @param phpQueryObject $phpQueryObject
     * @return array|mixed
     * @throws Exception
     */
    private static function parseScriptData(phpQueryObject $phpQueryObject)
    {
        $scripts = $phpQueryObject->find('script')->elements;
        $sharedData = [];

        foreach ($scripts as $script) {
            $script = pq($script);

            if (strpos($script->text(), 'window._sharedData = ') !== false) {
                list(, $rawSharedData) = explode('window._sharedData = ', $script->text());
                $sharedData = str_replace(';', '', $rawSharedData);
            }
        }

        return json_decode($sharedData, 1);
    }
}