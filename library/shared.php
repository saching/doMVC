<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$sTime = microtime();
$sTime = explode(" ", $sTime);
$sTime = $sTime[1] + $sTime[0];

/** Check if environment is development and display errors * */
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

/** Check for Magic Quotes and remove them * */
function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them * */
function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function * */
function callHook() {
    global $url;

    $routeParams = getRoutePath($url);

    if (class_exists($routeParams['controller'])) {
        dispatch($routeParams['controllerName'], $routeParams['action'], $routeParams['queryString']);
    } else {
        $urlArray = explode("/", ERROR_404);
        dispatch($urlArray[1], $urlArray[2], null);
    }
}

function dispatch($controllerName, $action, $queryString) {
    $controller = $controllerName . 'Controller';
    $dispatch = new $controller($controllerName, $action);

    if ((int) method_exists($controller, $action)) {
        call_user_func_array(array($dispatch, $action), $queryString);
    } else {
        $dispatch->redirect(ERROR_404);
    }
}

/** Autoload any classes that are required * */
function __autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.php');
    } elseif (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } elseif (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } elseif (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } elseif (file_exists(ROOT . DS . 'plugins' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'plugins' . DS . $className . '.php');
    } else {
        /* Error Generation Code Here */
    }
}

function getRoutePath($url) {
    global $routes;
    if (substr($url, -1) !== '/')
        $url = '/' . $url;



    if (array_key_exists($url, $routes)) {
        $action = $routes[$url]['action'];
        $controller = $routes[$url]['module'];
        $queryString = array();
    } else {
        $param = getRouteByPattern($url);
        if ($param != null && count($param) > 0) 
            $url = $param;
        

        $url = substr($url, 1);
        if (strlen($url) < 1)
            $url = substr(HOME_PAGE, 1);

        $urlArray = array();
        $urlArray = explode("/", $url);

        $controller = $urlArray[0];
        array_shift($urlArray);
        $action = $urlArray[0];
        array_shift($urlArray);
        $queryString = $urlArray;
    }

    $controllerName = $controller;
    $controller = ucwords($controller);
    $controller .= 'Controller';

    return array('controllerName' => $controllerName, 'controller' => $controller, 'queryString' => $queryString, 'action' => $action);
}

function getRouteByPattern($url) {
    global $routes;
    $i = 0;
    $returnUrl = null;
    //$url = substr($url, 1);
    $matches = explode("/", $url);
    foreach ($routes as $u => $data) {
        $routeSlice = explode("/", $u);
        $pureUrl = substr(substr($u, 0, strpos($u, "/:")), 1);
        if (in_array($pureUrl, $matches) && count($matches) == count($routeSlice)) {
            $intersect = array_intersect($matches, $routeSlice);
            foreach ($intersect as $rmVal) {
                foreach ($routeSlice as $i => $val) {
                    if ($rmVal == $val) {
                        unset($routeSlice[$i]);
                        unset($matches[$i]);
                    }
                }
            }
            $returnUrl = ("/" . $data['module'] . "/" . $data['action'] . "/" . implode("/", $matches));
        }
    }
    return $returnUrl;
}

session_start();
setReporting();
removeMagicQuotes();
unregisterGlobals();
$_SESSION['sTime'] = $sTime;
callHook();
