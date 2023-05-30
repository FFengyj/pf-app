<?php

$bash = realpath(__DIR__ . '/..');

if(isset($argv[1]) && trim($argv[1])){
    $name = ucfirst(str_replace('_', '', ucwords(trim($argv[1]), '_')));
}else {
    echo "usage: migrate.sh ClassName \n";
    exit(-1);
}

$conf = "{$bash}/phinx/config.php";
$tpl  = "{$bash}/phinx/Migration.template.php.dist";
$bin  = "{$bash}/vendor/robmorgan/phinx/bin/phinx create";

exec(sprintf("%s --configuration %s --template %s %s",$bin,$conf,$tpl,$name),$output,$ret);
$output =  join("\n",$output);

echo $output,"\n";

if($ret == 0){

    if(preg_match("|created phinx/migrations/(.*)\.php|",$output,$match)){
        file_put_contents("{$bash}/phinx/migrations/sql/{$match[1]}.up.sql","");
        file_put_contents("{$bash}/phinx/migrations/sql/{$match[1]}.down.sql","");
    }
}

?>




