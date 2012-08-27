<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Controller extends Core {

    /**
     * Controller name
     */
    protected $_controller;

    /**
     * Action name
     */
    protected $_action;

    /**
     * Template object
     */
    protected $_template;

    /**
     * Validator Object
     */
    protected $validator;

    /**
     * Parameterised constructor
     * parameters controller name and action name
     */
    function __construct($controller, $action) {

        //call parent constructor
        parent::__construct($action, $controller);

        //set the controller and action name
        $this->_controller = $controller;
        $this->_action = $action;

        //load user mgt
        if (USER_MODULE) {

            if ($this->hasAttribute('User'))
                $this->setUser($_SESSION['User']);
            else {
                $user = new usermgt();
                $this->setUser($user);
            }
        }

        //set up template object
        $this->_template = new Template($controller, $action);
        $this->_template->setUser(Core::$_user);

        //create validator object
        $this->validator = new FormValidator();
    }

    /**
     * Method to load models, plugins
     */
    function load($models = array()) {
        if (!is_array($models) && $models != null)
            $models = array($models);

        foreach ($models as $model)
            $this->$model = new $model;
    }

    /**
     * Method to set view variables
     */
    function set($name, $value) {
        $this->_template->set($name, $value);
    }

    /**
     * Method to set page title
     */
    function setTitle($title) {
        $this->_template->setTitle($title);
    }

    /**
     * Destructor of the class
     */
    function __destruct() {
        if ($this->isPost() && count($this->validator->GetErrors()) > 0)
            $this->set("error", $this->validator->GetErrors());

        $this->_template->render();
    }

    /**
     * Method to include a CSS file
     */
    function addCss($file) {
        $this->_template->addCss($file);
    }

    /**
     * Method to include the JS file
     */
    function addJs($file) {
        $this->_template->addJs($file);
    }

    /**
     * Method to set layout for the current page
     */
    function setLayout($layout) {
        $this->_template->setLayout($layout);
    }

    function setView($view) {
        $this->_template->setView($view);
    }

}
