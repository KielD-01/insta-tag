<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 2019-01-29
 * Time: 14:03
 */

namespace KielD01\InstaTag\Traits;


/**
 * Class Attributes
 * @package KielD01\InstaTag\Traits
 * @method
 */
trait Attributes
{

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->{$key};
    }
}