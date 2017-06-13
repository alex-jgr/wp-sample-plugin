<?php
namespace SamplePlugin\Core;

abstract class Singleton
{
    /**
     * Call this method to get singleton
     */
    public static function getInstance()
    {
      static $instance = false;
      if( $instance === false )
      {
        // Late static binding (PHP 5.3+)
        $instance = new static();
      }

      return $instance;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct() {
        $this->baseDir = dirname(__DIR__);
    }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {}

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {}

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup() {}
    
    public $baseDir;
}