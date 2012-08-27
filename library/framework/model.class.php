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
 * Base Model Class
 * 
 * this class will help,
 * 1. to build connection with db
 * 2. to close connection with db
 * 3. useful to write common method used accross the all child models
 * 
 */
class Model extends SQLQuery {

    /**
     * store the current model reference
     */
    protected $_model;
    protected $_query;

    /**
     * constructor that connects to the db server
     * it read all required parameters from the config/config.php file
     * 
     */
    function __construct() {
        if (DB) {
            $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $this->_model = get_class($this);
            $this->_table = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $this->
                _model)) . "s";
        }
    }

    /**
     * destructor
     */
    function __destruct() {
    }
    
    public function getQuery(){
        return $this->_query;
    }

    /**
     * Common method to save row in database table
     * @param $contentValues - contentValues is a mapped array database key and database values
     */
    public function save($contentValues) {
		try{
			$query = "INSERT INTO " . $this->_table . " (__COLUMNS__) VALUES( __VALUES__ )";
			$columns = "";
			$values = "";
			foreach ($contentValues as $key => $value) {
				$columns .= ", " . $key;
				if (is_numeric($value))
					$values .= ', ' . $value;
				else
					$values .= ', "' . mysql_real_escape_string($value) . '"';

			}

			$query = str_replace(array("__COLUMNS__", "__VALUES__"), array(substr($columns,
				1), substr($values, 1)), $query);
            $this->_query = $query;
            $this->query($query);
            return mysql_insert_id();
		}catch(Exception $ex){
			echo $ex;
		}
        return null;
    }
}
