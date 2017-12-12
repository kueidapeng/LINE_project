<?php
namespace App\event;

use App\event\UtilityHandler;
use Predis\Autoloader as PredisAutoloader;

class RedisHandler {
 
     private $redis;

    public function __construct()
    {
        PredisAutoloader::register();
       $this->redis = new \Predis\Client(getenv('REDIS_URL'));
    }
    public function addUserId($user_id)
    {
      $result= UtilityHandler::toBoolean($this->redis->hset($user_id,'user_id',$user_id));
      return $result;
    }
    public function deleteUserId($user_id)
    {
      $result= UtilityHandler::toBoolean($this->redis->del($user_id));
      return $result;
    }
    public function checkUserId($user_id)
    {
      $result= UtilityHandler::toBoolean($this->redis->exists($user_id));
      return $result;
    }
    public function checkUserLocation($user_id,$latitude,$longitude)
    {
        $user=$this->redis->hgetall($user_id);
        if(empty($user))
        {
          return UtilityHandler::toBoolean(0);
        }
        if(isset($user['latitude']) && isset($user['longitude'])){
            $result=1;        
         }else{
            $result=0;        
         }
        return UtilityHandler::toBoolean($result);
    }
    
   
}
