<?php

/*
 * This file is part of the 'do' package.
 *
 * (c) Sachin Gosarade <usercircle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/** Configuration Variables **/
define ('DEVELOPMENT_ENVIRONMENT',false);

/** Database config */
define('DB', false);
define('DB_NAME', 'CHANGE DB NAME HERE');
define('DB_USER', 'CHANGE USER NAME HERE');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');

/** CSRF token key **/
define('CSRF_HASH', 'asjdfhiauf7938ry3hfjdkjfy3ryhf');



/** Define default routes */
define('HOME_PAGE', '/');
define('ERROR_404', '/site/error404');

$routes = array(
    
    '/' => array('module'=> 'site', 'action'=>'home'),
    '/about' => array('module'=> 'site', 'action'=>'about'),
    '/contact' => array('module'=> 'site', 'action'=>'contact'),
    '/hello/:name' => array('module'=> 'site', 'action'=>'hello'),
    '/hello/:name/:event' => array('module'=> 'site', 'action'=>'hello'),
    '/hi/:name/:event' => array('module'=> 'site', 'action'=>'hello'),
    
);
