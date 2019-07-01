<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Utils;

class Uuid
{
    /**
     * @return string
     */
    public static function generate() : string
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    /**
     * @param $name
     * @return string
     */
    public static function hash($name) : string
    {
        return \Ramsey\Uuid\Uuid::uuid3(\Ramsey\Uuid\Uuid::NAMESPACE_OID, $name)->toString();
    }

}