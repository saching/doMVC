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
 * @author Sachin
 * @copyright 2011
 */
$vUser = null;

/**
 * method to include partial
 */
function include_partial($path, $params = array()) {

    foreach ($params as $key => $value)
        $$key = $value;

    include (ROOT . DS . 'application' . DS . 'views' . DS . $path . '.php');
}

/**
 * method to print the form errors
 */
function printError($errors, $field) {
    if (array_key_exists($field, $errors))
        echo "<p class='help-block error'>" . $errors[$field] . "</p>";
}

/**
 * method to get form field post value
 */
function getFormValue($key, $return) {
    if (array_key_exists($key, $_POST))
        return $_POST[$key];

    if (array_key_exists($key, $_GET))
        return $_GET[$key];

    return $return;
}

/**
 * method to get form errors
 */
function form_errors($error) {
    if ($error != null) {
        echo '<p class="error">';
        $cnt = count($error);
        foreach ($error as $err)
            echo $err . ((--$cnt > 0) ? ', ' : '');

        echo '</p>';
    }
}

/**
 * method to get page load time
 */
function pageLoadTime() {

    if (array_key_exists("sTime", $_SESSION) === true) {
        $sTime = $_SESSION["sTime"];
        $diff = time() - $sTime;
        echo ($diff ) . " seconds";
    } else {
        echo "NaN";
    }
}

/**
 * default pagination implementation
 */
function pager($url = null, $noOfRows = 0, $currentPage = 1, $rowsPerPage = 10) {
    if ($url == null || $noOfRows == 0)
        return '';

    $url .= "/";

    $noOfPages = ($noOfRows % $rowsPerPage) > 0 ? (floor($noOfRows / $rowsPerPage) + 1) : ($noOfRows / $rowsPerPage);
    $pages = '<ul class="extra-space-bottom" id="pagination-clean">';

    if ($currentPage > 1)
        $pages .= '<li class="previous"><a href="' . $url . ($currentPage - 1) . '">&lArr; Previous</a></li>';
    else
        $pages .= '<li class="previous-off">&lArr; Previous</li>';

    for ($i = 1; $i <= $noOfPages; $i++) {
        if ($currentPage == $i)
            $pages .= '<li class="active">' . $i . '</li>';
        else
            $pages .= '<li><a href="' . $url . $i . '">' . $i . '</a></li>';
    }

    if ($currentPage < $noOfPages)
        $pages .= '<li class="next"><a href="' . $url . ($currentPage + 1) . '">Next &rArr;</a></li>';
    else
        $pages .= '<li class="next-off">Next &rArr;</li>';

    $pages .= '</ul>';

    echo $pages;
}

/**
 * method to print csrf token 
 */
function printCsrfToken() {
    //csrf token generation code
    if (strtolower($_SERVER['REQUEST_METHOD']) != 'post')
        Core::generateCSRF();

    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION["csrf_token"] . '" readonly="true" />';
}

/**
 * method to print input
 * @param type $name
 * @param type $value
 * @return string 
 */
function field_input($name = null, $props = array()) {
    if (!$name)
        return "";

    $name = str_replace(" ", "_", $name);
    $formValue = getFormValue($name, null);
    if ($formValue != null)
        $props['value'] = $formValue;

    echo '<input id="input_' . $name . '" name="' . $name . '" ' . getArrayAsPropertyString($props) . ' />';
}

function getArrayAsPropertyString($arr = null) {
    if ($arr == null)
        return "";

    $str = "";
    foreach ($arr as $key => $value)
        $str .= $key . '="' . $value . '"';

    return $str;
}
?>

