<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


/************************************ config.php **************************************
 *                                                                                    *
 *                 Do not push this file to any other server.                         *
 *                                                                                    *
 *  config.php file contains configuration info which differs from server to server.  *
 *     When modifying this file, make changes on each individual server.              *
 *                                                                                    *
 **************************************************************************************/


// host/user/pass
$host = "a525a02442eb32ce6698509dc480168c11ae2a4f.rackspaceclouddb.com";
$dbase = "nibbles_stage" ;
$user = "nibbles_stage" ;
$pass = "gSMrxr94NY6Kox}" ;

/* //Legacy reporting host/user/pass */
/* $reportingHost = "a525a02442eb32ce6698509dc480168c11ae2a4f.rackspaceclouddb.com"; */
/* $reportingDbase = "nibbles_stage"; */
/* $reportingUser = "nibbles_stage"; */
/* $reportingPass = "gSMrxr94NY6Kox}"; */


// DO NOT CHANGE THIS LINE!
mysql_pconnect ($host, $user, $pass);
mysql_select_db ($dbase);

/* $bGlobalJoinInsertDisable = false; */


/* $aGblSites = array( */
/*   "site1" => "216.48.124.134", */
/*   "w1" => "216.48.124.134" */
/* ); */

/* $aGblSiteNames = array( */
/*   "site1" => "admin.popularliving.com", */
/*   "site2" => "web1.popularliving.com", */
/*   "site3" => "web2.popularliving.com", */
/*   "test" => "test.popularliving.com", */
/*   "smita" => "smita.popularliving.com", */
/*   "josh" => "josh.popularliving.com", */
/*   "jr" => "jr.popularliving.com", */
/*   "lee" => "lee.popularliving.com", */
/*   "site4" => "web3.popularliving.com", */
/*   "site5" => "web4.popularliving.com", */
/*   "w1" => "test1.popularliving.com" */
/* ); */

/* $sGblSiteIp1 = "216.48.124.135"; */
/* $sGblSiteIp2 = "216.48.124.135"; */
/* $sGblSiteIp3 = "216.48.124.135"; */
/* $sGblSiteIp4 = "216.48.124.135"; */
/* $sGblSiteIp5 = "216.48.124.135"; */
/* $sGblSiteIp6 = "216.48.124.135"; */
/* $sGblSiteIp7 = "216.48.124.135"; */


/* $sGblRoot = "/var/www/html/admin.popularliving.com"; */
$sGblWebRoot = "/var/www/html/admin.popularliving.com/html";
$sGblAdminWebRoot = "$sGblWebRoot/admin";
/* $sGblRootMyFree = "/var/www/html/www_myfree_com"; */
/* $sGblWebRootMyFree = "/var/www/html/www_myfree_com/html"; */

/* $sGblMainSiteRoot = "http://www.popularliving.com"; */
$sGblSiteRoot = "http://admin.popularliving.com";
/* $sGblSiteRootMyFree = "http://www.myfree.com"; */
/* $sCurrSite = $_SERVER['SERVER_ADDR']; */

/* reset($aGblSiteNames); */
/* reset($aGblSites); */
/* while (list($key,$val) = each($aGblSites)) { */
/*   if ($sCurrSite == $val) { */
/*     $sGblSiteRoot = "http://".$aGblSiteNames[$key]; */
/*   } */
/* } */

// specify site root of the images specified on different server
$sGblImageServerSiteRoot = "http://images.popularliving.com";

$sGblAdminSiteRoot = "http://stage.popularliving.com/admin";

/* $sGblExportReportUrl = "http://admin.popularliving.com"; */

/* // Redirect paths */
/* $sGblEditorialPath = "http://ed.myfree.com"; */
/* $sGblOfferRedirectsPath = $sGblEditorialPath."/r/r.php"; */
/* $sGblSourceRedirectsPath = "http://www.popularliving.com/r/r.php"; */

/* // Pixels Tracking paths */
/* $sGblOfferPixelsTrackingPath = $sGblEditorialPath."/pixels/offerPixelTracking.php"; */
/* $sGblSourcePixelsTrackingPath = "http://www.popularliving.com/pixels/pixelTracking.php"; */
/* $sGblNlPixelsTrackingPath = $sGblEditorialPath."/pixels/nlPixelTracking.php"; */

/* //set default url, if url not found ( used in /r/r.php ) */
/* $sGblDefaultUrl = "http://www.popularliving.com/p/onetime.php"; */

/* // specify handcraftersvillage db name */
/* $sGblHcvDBName = "hcv"; */
/* $sGblHcvWebRoot = "/var/www/html/hcv"; */
/* $sGblHcvSiteRoot = "http://cory.myfree.com/hcv"; */


/* $sGblMhlDBName = "hl"; */
/* $sGblMhlWebRoot = "/var/www/html/hl"; */
/* $sGblMhlSiteRoot = "http://cory.myfree.com/hl"; */

/* $sGblFpWebRoot = "/var/www/html/funpages.myfree.com"; */
/* $sGblFpSiteRoot = "http://funpages.myfree.com"; */


/* // [PAGE_2_HTML_IMAGE_PATH] */
/* $sPage2HtmlImagePath = "http://www.popularliving.com/images/offers"; */
