<?php
namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: tuman
 * Date: 2018-06-12
 * Time: 14:29
 */

trait Singleton
{
    private static $instance = null;

    protected function __construct(){}

    final private function __clone(){}
    final private function __wakeup(){}

    public static function getInstance()
    {
        return (self::$instance === null)
            ? self::$instance = new self()
            : self::$instance;
    }
}
