<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Represents the Core class for controllers.
 * contains common methods for the controllers.
 */
abstract class Core {

    /**
     * defines the current module name
     */
    protected $_model;

    /**
     * defines current user object
     */
    public static $_user;

    /**
     * Constructor of the class
     * sets the current action and module name 
     */
    function __construct($actionName, $moduleName) {
        $this->actionName = $actionName;
        $this->moduleName = $moduleName;
    }

    /**
     * Destructor of the class
     */
    function __destruct() {
        
    }

    /**
     * method to get session variable value
     */
    public function getAttribute($key, $returnValue = null) {
        return self::getAttr($key, $returnValue = null);
    }

    /**
     * method to set session variable
     */
    public function setAttribute($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * method to unset the session variable
     */
    public function clearAttribute($key) {
        unset($_SESSION[$key]);
    }

    /**
     * method to get POST/GET variable
     */
    public function getParameter($key, $returnValue = null) {
        return self::getParam($key, $returnValue);
    }

    /**
     * method to check session variable is exists or not
     */
    public function hasAttribute($key) {
        return self::hasAttr($key);
    }

    /**
     *  method to check whether parameter is exists ot not
     */
    public function hasParameter($key) {
        return self::hasParam($key);
    }

    /**
     * method to redirect the page
     */
    public function redirect($url) {
        header('Location: ' . $url);
    }

    /**
     * method to get request method
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * method to check whether it is a POST/GET request method
     */
    public function isPost() {
        if ('post' == strtolower($this->getMethod()))
            return true;

        return false;
    }

    /**
     * static method to get session variable value
     */
    public static function getAttr($key, $returnValue = null) {
        if (array_key_exists($key, $_SESSION))
            return $_SESSION[$key];

        return $returnValue;
    }

    /**
     * static method to set session variable
     */
    public static function setAttr($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * static method to remove the session var
     */
    public static function clearAttr($key) {
        unset($_SESSION[$key]);
    }

    /**
     * static method to get query string or post var
     */
    public static function getParam($key, $returnValue = null) {
        if (array_key_exists($key, $_POST))
            return $_POST[$key];

        if (array_key_exists($key, $_GET))
            return $_GET[$key];

        return $returnValue;
    }

    /**
     * static method to redirect the page
     */
    public static function redirectUrl($url) {
        header('Location: ' . $url);
    }

    /**
     * static method to check session variable is exists or not
     */
    public static function hasAttr($key) {
        if (array_key_exists($key, $_SESSION))
            return true;
        return false;
    }

    /**
     * static method to check whether parameter is exists ot not
     */
    public static function hasParam($key) {

        //check in post
        if (array_key_exists($key, $_POST))
            return true;

        //check in get
        if (array_key_exists($key, $_GET))
            return true;

        return false;
    }

    /**
     * method to get referer
     */
    public static function getReferer() {
        return $HTTP_REFERER;
    }

    /**
     * method to set static user object
     */
    public function setUser($user) {
        Core::$_user = $user;
    }

    /**
     * method to set static user object
     */
    public function getUser() {
        return Core::$_user;
    }

    /**
     * method to generate csrf token 
     */
    public static function generateCSRF() {
        $token = md5(uniqid(rand(), TRUE) . CSRF_HASH);
        $tokenTime = time();

        Core::setAttr("csrf_token", $token);
        Core::setAttr("csrf_token_time", $tokenTime);
    }

    /**
     * method to verify csrf token 
     */
    public function isValidCSRF() {
        $token_age = (time() - $this->getAttr('csrf_token_time')) / 60;
        if ($this->getParameter("csrf_token", null) != null
                && $this->getAttr("csrf_token", null) == $this->getParameter("csrf_token", null)
            && $token_age <= 5){
            return true;
        }
        else
            return false;
    }

}
