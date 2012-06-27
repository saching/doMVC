Welcome to "doMVC"
------------------

PHP light framework.

Introduction:
A simple PHP framework, which serves basic libraries, templates and MVC structure in a simple way. It’s light, faster to load and easy to understand.

Directory Structure:
-application
 --controllers
 --models
 --views
  ---template
  ---<folder: Controller Name>
-config
-library
-tmp
-public
 --css
 --img
 --js
 --index.php
-.htaccess

___

application:
------------

This folder contains 3 sub folders (controllers, models and views). This folder represents as a single application. (TODO: multiple application support)

**controllers:**
	A controller is nothing more than a class extending base “Controller” that groups several action methods.

**What is an Action?**
Most of the requests received by an application are handled by an Action.
An action is basically a Java method that processes the request parameters, and produces a result to be sent to the client.

**How to create new Controller Class?**
	
	//Represents the Controller class
	class MyController extends Controller {
		//write you actions here
	}
	

Note: Save this file in a following format
<controller-name-in-small-case>.php so the above code will be saved in a file called “mycontroller.php”

**How to add Action in a Controller Class?**

	//Represents the Controller class
	Class MyController extends Controller {
		//Represents the action
		function hello($name = “Guest”) {
			// your logic will go here
		}
	}


---
models:
------

The model is a collection of PHP classes that form a software application intended to store, and optionally separate, data. A single front end class that can communicate with any user interface (for example: a console, a graphical user interface, or a web application).

**How to create new Model Class?**
	
	//Represents the model class
	class MyModel extends Model {
		//write you methods here
	}
	
views:
------

The view renders the model into a form suitable for interaction, typically a user interface element. Multiple views can exist for a single model for different purposes. A view port typically has a one to one correspondence with a display surface and knows how to render to it.

**How to create new view file?**
	
	If( i < 10){
	//do your stuff
	}
	
Note: You can create simple php file with html content integrated with php code. You need to save this file as “<action-name>.php” in a folder called “<controller-class-name without ‘controller’ extension>.php”, so above code will be saved as “hello.php” in “my” folder located under “views” folder.


Accessible Methods In Controller:
--------------------------------

Following method will be useful for you while developing your app using doMVC.
	
	$this->load($model);
	
Method is useful to load model class or to plug-in for a particular page. You can load single or multiple model/plug-in class using this method.

**E.g.**
To load the ‘User’ class you can call.
$this->load(‘User’); or to load multiple class $this->load(array(‘User’, ‘Profile’));

$this->set('key', $value);
Method used to set view variable, using this set method you can push the value to view layer. After that value can be easily accessed in view page.
//push the value using in controller actions
$this->set(‘limit’, 4);

//access the value in view file
<?php echo $limit; ?>


$this->setAttribute ('key', $value);
Method used to set session variables.

$this->getAttribute ('key', $value);
Method used to get session variable value with index ‘key’. If such passed key is not found in session the default value will be returned with is ‘$value’.

$this->clearAttribute ('key');
Method used to remove the session variable.

$this->hasAttribute ('key');
Method to check session variable is exists or not.
$this->getParameter ('key', $value);
Method to get ‘GET’ or ‘POST’ parameter, $value will be returned as default value if the ‘key’ index is not found in GET/POST array.

$this->hasParameter ('key');
This method is used to check whether this parameter is set or not.

$this->redirect ('url');
This method used to redirect the current page to another page.

$this->getMethod ();
This method is used to request method.

$this->isPost();
This method is used to check whether it is POST method or not.

$this->setTitle(‘title’);
This method is used to set page title.

$this->addCss(‘file’);
Method used to load separate CSS file.

$this->addJs(‘file’);
Method used to load separate JS file.

$this->setLayout(‘layoutFile’);
Method to set separate layout for current page. You can disable to layout for the current page using $this->setLayout(false);
