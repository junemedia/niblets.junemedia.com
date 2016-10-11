<?php

// set the config file path
$sConfigFile = "/var/www/html/admin.popularliving.com/config.php";

// include config file
include($sConfigFile);


$sGblImagePath = "$sGblWebRoot/images";
$sGblImageUrl = "$sGblSiteRoot/images";

$sGblOfferImagePath = "$sGblImagePath/offers";
$sGblOfferImageUrl = "$sGblImageUrl/offers";

$sGblOfferImagesPath = "$sGblImagePath/offers";
$sGblOfferImagesUrl = "$sGblImageUrl/offers";

$sGblDisplayOfferImagesUrl = $sGblImageServerSiteRoot."/images/offers";

// path where generated ot pages stored/should be stored
$sGblOtPagesPath = "$sGblWebRoot/p";
$sGblOtPagesUrl = "$sGblSiteRoot/p";

$sGblPageImagesPath = $sGblOtPagesPath;

// images are copied on separate image server
$sGblPageImagesUrl = "$sGblImageServerSiteRoot/p";


$sGblDisplayPageImagesUrl = $sGblImageServerSiteRoot."/p";


$sGblLibsPath = "$sGblWebRoot/libs";
$sGblLibsUrl = "$sGblSiteRoot/libs";

$sGblIncludePath = "$sGblWebRoot/includes";

$sGblLeadFilesPath = "$sGblAdminWebRoot/leads";

// leads file import directory
$sGblImportLeadsDir = "$sGblWebRoot/partners/upload";

// set Campaign Frames Root
$sGblCampaignFrameRoot = $sGblWebRoot."/campaignFrames/" ;

$sGblPartnersPath = "$sGblWebRoot/partners";
$sGblPartnersUrl = "$sGblSiteRoot/partners";


// include library file before including any other files
include("$sGblLibsPath/dbFunctions.php");

// include library file
include("$sGblLibsPath/library.php");

$sGblForeignIPRedirectURL = "http://www.globaloffermall.com/index.php?pid=179&subid=ampGL";
