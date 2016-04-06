<?php

/************************************ config.php **************************************
 *                                                                                    *
 *                 Do not push this file to any other server.                         *
 *                                                                                    *
 *  config.php file contains configuration info which differs from server to server.  *
 *     When modifying this file, make changes on each individual server.              *
 *                                                                                    *
 **************************************************************************************/


// host/user/pass
$host = "host";
$dbase = "database" ;
$user = "dbuser" ;
$pass = "password" ;

// DO NOT CHANGE THIS LINE!
mysql_pconnect ($host, $user, $pass);
mysql_select_db ($dbase);

$sGblWebRoot = "/path/to/web/root";
$sGblAdminWebRoot = "$sGblWebRoot/admin";

// base url of site
$sGblSiteRoot = "http://www.mysite.com";

// specify site root of the images specified on different server
$sGblImageServerSiteRoot = "http://images.mysite.com";

// url of admin site
$sGblAdminSiteRoot = "http://www.mysite.com/admin";
