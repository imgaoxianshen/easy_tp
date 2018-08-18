<?php

class App
{
    // controller默认控制器
    const DEFAULT_CONTROLLER = 'index';

    // 默认action
    const DEFAULT_ACTION = 'index';

    //控制器类前缀
    const PREFIX_CONTAOLLER = 'Controller';

    // 控制器前端传回的参数
    const PARAMNAME_CONTROLLER = 'c';

    // 控制器action的参数
    const PARANAME_ACTION = 'a';


    public static function run(){
        $controllerName = self::get(self::PARAMNAME_CONTROLLER, self::DEFAULT_CONTROLLER);
        $actionName = self::get(self::PARANAME_ACTION , self::DEFAULT_ACTION);
        $controllerClass = self::PREFIX_CONTAOLLER . ucfirst(strtolower($controllerName));
        if(!class_exists($controllerClass)){
            self::_404('controller '.$controllerName." not found!");
        }

        $controller = new $controllerClass();
        if(!method_exists($controller, $actionName)){
            self::_404('action '.$action." not found!");
        }

        $controller->$actionName();

    }


    // 获取get参数
    public static function get ($name, $default = ''){
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    // 获取post参数
    public static function post ($name, $default = ''){
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    //生成URL的绝对路径
    public static function genUrl($controller, $action ,$param = []){
        $urlStr = "/?" . self::PARAMNAME_CONTROLLER . "= ". $controller . "&" . self::PARANAME_ACTION . "=" . $action;
        if(!empty($param)){
            foreach($param as $k =>$v){
                $k = trim($k);
                if($k == self::PARAMNAME_CONTROLLER || $k == self::PARANAME_ACTION){
                    continue;
                }

                if(!empty($k)){
                    $urlStr .= "&{$k}={$v}";
                }
            }
        }
        return $urlStr;
    }


    // 404
    public static function _404($msg = ''){
        header('HTTP/1.1 404 NOT Found');
        exit('<h1>404 not found </h1><br>'.$msg);
    }
}