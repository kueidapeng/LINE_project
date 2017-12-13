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
    public function addUserLocation($user_id,$latitude,$longitude)
    {
      if($user_id==='' || $latitude==='' || $longitude===''){
        return UtilityHandler::toBoolean(0);
      }
      try {
        $result_latitude= $this->redis->hset($user_id,'latitude',$latitude);
        $result_longitude= $this->redis->hset($user_id,'longitude',$longitude);
      } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
      
      if($result_latitude === 1 &&  $result_longitude === 1 ){
         $result=1;        
      }else{
         $result=0;        
      }
       return UtilityHandler::toBoolean($result);
    }
    public function  updateUserLocation($user_id,$latitude,$longitude)
    {
      if($user_id==='' || $latitude==='' || $longitude===''){
        return UtilityHandler::toBoolean(0);
      }
           
      try {
       $this->redis->hset($user_id,'latitude',$latitude);
       $this->redis->hset($user_id,'longitude',$longitude);
      } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
     
       return UtilityHandler::toBoolean(1);
    }
    public function checkUserLocation($user_id,$latitude,$longitude)
    {
        if($user_id==='' || $latitude==='' || $longitude===''){
          return UtilityHandler::toBoolean(0);
        }
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
