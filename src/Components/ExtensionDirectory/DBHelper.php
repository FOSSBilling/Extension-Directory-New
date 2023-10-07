<?php

namespace ExtensionDirectory;

class DBHelper
{
    public static function getStoreObject(string $name, ?string $pk = null)
    {
        if ($pk) {
            return new \SleekDB\Store($name, BASE_PATH . DIRECTORY_SEPARATOR . 'testDB', ['primary_key' => $pk]);
        } else {
            return new \SleekDB\Store($name, BASE_PATH . DIRECTORY_SEPARATOR . 'testDB');
        }
    }
}
