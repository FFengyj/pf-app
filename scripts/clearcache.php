<?php

$env = \Yaconf::get("spark_app.env.name");
if(!$env){
   echo "Error: env file not exists!\n"; exit;
}

if(!in_array($env,['dev','test'])){
    echo "Error: '{$env}' \n"; exit;
}

$variables = require __DIR__ .  '/../App/Config/' .ucfirst($env). '/config.php';

$redis_config = $variables['redis_server']['main'] ?? [];
if(!$redis_config){
    echo "Redis Config is undefined.\n";
    exit;
}


$handle = fopen("php://stdin","r");

echo "Please input key prefix (input 'ALL' for flushDB):\n";

$key_prefix = "";
while(1){

  if($key_prefix = rtrim(trim(fgets($handle)),"*")){
     break;
  }
}

echo ($key_prefix == "ALL" ?  "Confirm: flushDB ?" : "Confirm: clear {$key_prefix}* keys ?") , " [y/n]:\n";
while(1){

   if($op = trim(fgets($handle))){
      if($op != 'y'){
         exit;
      }
      break;
    }
}

$redis = new \Redis();
$redis->connect($redis_config['host'], $redis_config['port']);
if($redis_config['password']){
    $redis->auth($redis_config['password']);
}
$redis->setOption(\Redis::OPT_SCAN,\Redis::SCAN_RETRY);

if($key_prefix == 'ALL'){

    if(!$redis->flushDB()){
        echo "flushDB fail.\n";
    }else {
        echo "Complete! flushDB success.\n";
    }

    exit;
}

$count = 0;
while($keys = $redis->scan($iterator,"{$key_prefix}*")) {
    $count += $redis->del($keys);
}

echo "Complete! key count:{$count};\n";

exit;

?>




