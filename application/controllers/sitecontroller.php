<?php

/**
 * Represent the Site controller
 * 
 */
class siteController extends Controller {

    /**
     * Represents the home page of the site
     */
    function home() {
        $this->load(array("MyP"));

        //Plugin call
        //$this->MyP->showMyName();
    }

    /**
     * Represents the about page of the site
     */
    function about() {
        
    }

    /**
     * page not found action
     */
    function error404() {
        
    }

    /**
     * contact form example
     * csrf functionality example
     */
    function contact() {
        if ($this->isPost()) {

            //set validators
            $this->validator->addValidation("name", "req", "Name required");
            $this->validator->addValidation("email", "email", "Invalid email");

            if (!$this->isValidCSRF())
                $this->set("status", "invalid csrf token.");
            else {
                if ($this->validator->ValidateForm()) {
                    
                    //TODO save record into database.
                    
                    $this->set("status", "contact successfully saved.");
                }
            }
        }
    }
    
    /**
     *  say hello to user, url mapping demo
     */
    function hello($name = "Guest", $event="hello"){
        $this->set('user', $name);
        $this->set('event', $event);
    }
    
}

?>