<?php
class RedisHandler {
 
     private $redis;

    public function __construct()
    {
       Predis\Autoloader::register();
       $this->redis = new Predis\Client();
    }
    public function checkUserId($userId)
    {
     //    return $userId;
     // $test=$this->redis->exists('test') ? "Oui" : "please populate the message key";
     $test=$this->redis->SETNX($userId,$userId);
     return $test;
    }
    // public function checkUserLocation($userId,$latitude,$longitude)
    // {
    // $test=$this->redis->SETNX($userId,$userId);
    //  return $test;
    // }
   
}
