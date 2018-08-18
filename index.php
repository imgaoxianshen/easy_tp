<?php
ini_set('date.timezone','PRC');

define('APP_ROOT',dirname(__FILE__));
define('LIB_PATH',APP_ROOT.'/lib');
define('VIEW_PATH',APP_ROOT.'/view');

// 自动加载函数
function app_autoload($className){
    $classFileName = LIB_PATH ."/".$className.'.php';
    if(!is_file($classFileName)){
        return false;
    }
    include_once $classFileName;
    if(!class_exists($className,false)){
        return false;
    }
    return true;
}

spl_autoload_register('app_autoload');

App::run();
