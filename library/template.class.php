<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Template {

	protected $variables = array();
	protected $_controller;
	protected $_action;
    protected $_user;
    protected $_pageTitle;
    protected $_includeCss = array();
    protected $_includeJs = array();
    protected $_layout = "layout";
	protected $_view;
    
	function __construct($controller,$action) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_view = $action;
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables[$name] = $value;
	}
    
    /** Set User Variables **/

	function setUser($value) {
		$this->_user = $value;
	}
    
    function setTitle($title){
        $this->_pageTitle = $title;
    }
    
    function setLayout($layout){
        $this->_layout = $layout;
    }
	
	function setView($view){
        $this->_view = $view;
    }

	/** Display Template **/

    function render() {
        if(!$this->_layout)
            return;
        
        extract($this->variables);
        
        //set global vars
        $_user = $this->_user;
        $title = $this->_pageTitle;
		
		//include common view function library
        require_once(ROOT . DS . 'library' . DS .  'view.php');
        
        $include_header = $this->generateHeader();
        
        $content_page = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php';
        include (ROOT . DS . 'application' . DS . 'views' . DS .'template' . DS . $this->_layout.'.php');
    }
    
    /** Add CSS **/
    function addCss($file){        
        if(!is_array($file))
            $this->_includeCss[] = $file;
        else
            $this->_includeCss = array_merge($this->_includeCss, $file);        
    }
    
    /** Add JS **/
    function addJs($file){        
        if(!is_array($file))
            $this->_includeJs[] = $file;
        else
            $this->_includeJs = array_merge($this->_includeJs, $file);        
    }
    
    /** Generate the dynamic include header **/
    function generateHeader(){        
        $headerString = '';
        
        foreach($this->_includeCss as $file)
            $headerString .= '<link href="'.$file.'" rel="stylesheet" type="text/css" />';
        
        foreach($this->_includeJs as $file)
            $headerString .= '<script type="text/javascript" src="'. $file .'"></script>';
            
        return $headerString;
    }

}
