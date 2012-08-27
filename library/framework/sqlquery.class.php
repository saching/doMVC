<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class SQLQuery
{
    protected $_dbHandle;
    protected $_result;

    /** Connects to database **/

    function connect($address, $account, $pwd, $name)
    {
        $this->_dbHandle = @mysql_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysql_select_db($name, $this->_dbHandle)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /** Disconnects from database **/

    function disconnect()
    {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function selectAll()
    {
        $query = 'select * from `' . $this->_table . '`';
        return $this->query($query);
    }

    function select($id)
    {
        $query = 'select * from `' . $this->_table . '` where `id` = \'' .
            mysql_real_escape_string($id) . '\'';
        return $this->query($query, 1);
    }


    /** Custom SQL Query **/

    function query($query, $singleResult = 0)
    {

        $this->_result = mysql_query($query, $this->_dbHandle);

        if (preg_match("/select/i", $query)) {
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
            $numOfFields = mysql_num_fields($this->_result);

            for ($i = 0; $i < $numOfFields; ++$i) {
                array_push($table, mysql_field_table($this->_result, $i));
                array_push($field, mysql_field_name($this->_result, $i));
            }

            while ($row = mysql_fetch_row($this->_result)) {
                for ($i = 0; $i < $numOfFields; ++$i) {
                    $table[$i] = trim(ucfirst($table[$i]), "s");
                    $tName = $this->to_camel_case($table[$i], true);
                    $tempResults[$tName][$field[$i]] = $row[$i];
                }
                if ($singleResult == 1) {
                    mysql_free_result($this->_result);
                    return $tempResults;
                }
                array_push($result, $tempResults);
            }
            mysql_free_result($this->_result);

            return ($result);
        }


    }

    function rowQuery($sql)
    {
        return $this->query($sql);
    }

    function count($query)
    {
        $this->_result = mysql_query($query, $this->_dbHandle);
        while ($row = mysql_fetch_row($this->_result))
            return $row[0];
    }

    /** Get number of rows **/
    function getNumRows()
    {
        return mysql_num_rows($this->_result);
    }

    /** Free resources allocated by a query **/

    function freeResult()
    {
        mysql_free_result($this->_result);
    }

    /** Get error string **/

    function getError()
    {
        return mysql_error($this->_dbHandle);
    }

    function to_camel_case($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    function from_camel_case($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }
}
