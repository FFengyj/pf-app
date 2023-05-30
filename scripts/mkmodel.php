<?php

use Pf\System\Bootstrap;
use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;

define('ROOT_PATH', dirname(__DIR__, 1));

require ROOT_PATH . '/system/autoload.php';



$options = [
    'root_path'   => ROOT_PATH,
];

$bootstrap = new Bootstrap(new CliDI(),$options);
$bootstrap(ConsoleApp::class,function(ConsoleApp $app,CliDI $di){

    function getFieldDefault($info)
    {

        if($info['COLUMN_KEY'] == 'PRI'){
            return null;
        }

        $default = "''";
        switch(getFieldType($info)){
            case 'string':
                if($info['COLUMN_DEFAULT'] == 'CURRENT_TIMESTAMP'){
                    return null;
                }
                $default =  !empty($info['COLUMN_DEFAULT']) ? "'" .$info['COLUMN_DEFAULT']."'" : "''";
                break;
            case 'float':
            case 'int':
                $default = !empty($info['COLUMN_DEFAULT']) ? intval($info['COLUMN_DEFAULT']) : 0;
                break;
            case 'null':
                $default = null;
                break;
        }

        return $default;
    }

    function getFieldComment($info)
    {
        $comment = $info['COLUMN_COMMENT'];

        if(!empty($comment)){
            return $comment;
        }

        if($info['COLUMN_KEY'] == 'PRI'){
            $comment = "PRI KEY";
        }else {
            $comment = $info['COLUMN_NAME'];
        }

        return $comment;
    }

    function getFieldType($info)
    {
        $type_map = [
            'char' => 'string',
            'text' => 'string',
            'int' => 'int',
            'timestamp' => 'null',
            'date'  => 'string',
            'decimal' => 'float'
        ];

        $type = 'string';
        foreach($type_map as $k => $v){

            if(strpos($info['COLUMN_TYPE'],$k) !== false){
                $type = $v;
                break;
            }
        }
        return $type;
    }

    function getModelName($str) {
        $value = ucwords(str_replace(['_', '-'], ' ', $str));
        $value = ucfirst(str_replace(' ', '', $value));
        return $value;
    }

    function toSnakeCase($str) {
        $output = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
        return $output;
    }

    $model_path = __DIR__ .  '/../app/Models';

    $dbs = $di->get('config')->db->toArray();

    $handle = fopen("php://stdin","r");
    echo "please input db key [ " .join(" , ",array_keys($dbs)) ." ]:\n";

    $select_db = [];
    while(1){
        if($db_key = trim(fgets($handle))){
            if(isset($dbs[$db_key])){
                $select_db = $dbs[$db_key];
                break;
            }
        }else {
            continue;
        }
        echo "db key '{$db_key}' is invalid, keys allow [" .join(" or ",array_keys($dbs)) ."]\n";
    }


    $dsn = sprintf('%s:host=%s;port=%d;dbname=%s;charset=%s',
        $select_db['adapter'], $select_db['host'], $select_db['port'], $select_db['dbname'], $select_db['charset']);

    $conn = new \PDO($dsn, $select_db['username'], $select_db['password']);

    $table_info = [];
    echo "please input table name: ";

    $n = 3;
    while(1){

        if($table_name = trim(fgets($handle))){
            $table_name = strtolower($table_name);
        }
        $sth = $conn->prepare("select * from INFORMATION_SCHEMA.Columns where table_name=:table and table_schema=:databases order by ORDINAL_POSITION asc");
        $sth->execute([
            'table' => $table_name,
            'databases' => $select_db['dbname']
        ]);
        $table_info = $sth->fetchAll(\PDO::FETCH_ASSOC);
        if(!empty($table_info)){
            break;
        }
        if($n < 1){
            echo "Error: `{$select_db['dbname']}`.`{$table_name}` is not exists!\n";
            exit;
        }
        echo "`{$select_db['dbname']}`.`{$table_name}` is not exists,please retry({$n}): ";
        $n--;
    }


    $entity = getModelName(ltrim(strstr($table_name,"_"),"_"))."Model";

    echo "please input model name (default: {$entity}):";
    if($model_name = trim(fgets($handle))){

        $suffix = substr($model_name, -5);
        if(strtolower($suffix) == 'model'){
            $model_name = substr($model_name,0,-5);
        }
        $entity = ucfirst($model_name)."Model";
    }

    $entity_property  = '';
    $datetime_cols = [];

    foreach($table_info as $field){

        $field_type    = getFieldType($field);
        $field_value   = getFieldDefault($field);
        $field_comment = getFieldComment($field);
        $field_name    = $field['COLUMN_NAME'];

        $field_value = $field_value === null ? ";" :  " = {$field_value};";

        $len = max(30 - strlen($field_name. $field_value),1);
        $comment = $field_comment ? str_repeat(" ",$len) . "//{$field_comment}" : '';


        $entity_property .= <<<EOF
    public \${$field_name}{$field_value}    $comment \r\n
EOF;

        if($field['COLUMN_DEFAULT'] == 'CURRENT_TIMESTAMP'){
            $datetime_cols[] = $field_name;
        }
    }

    $before_create = '';
    if(!empty($datetime_cols)){

        $before_create = <<<EOF
    public function beforeCreate(): void
    {

EOF;

        foreach($datetime_cols as $f){
            $before_create .= <<<EOF
        \$this->{$f} = date('Y-m-d H:i:s');\r\n
EOF;
        }

        $before_create .= <<<EOF
    }
EOF;

    }


    $tpl = file_get_contents(__DIR__ . '/tpls/model.tpl');
    $tpl = str_replace(["{{entityName}}","{{entityProperty}}","{{beforeCreate}}","{{entityTable}}"],[$entity,$entity_property,$before_create,$table_name],$tpl);

    $file = $model_path . "/{$entity}.php";
    if(file_exists($file)){
        $backup = sprintf("%s/%s_%s.php",$model_path,$entity,date('Ymdhis'));
        if(!copy($file,$backup)){
            echo "model is exists,backup fail：{$backup}\n";
            exit;
        }
    }

    if(!file_put_contents($file,$tpl)){
        echo "create model fail: {$file}\n";
        exit;
    }



    echo "finish!\nmodel file: ".realpath($file)."\n";






});







?>




