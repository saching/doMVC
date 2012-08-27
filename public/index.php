<?php	

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$url = array_key_exists('url', $_GET)?$_GET['url']:'';

require_once (ROOT . DS . 'library' . DS . 'framework' . DS . 'bootstrap.php');
