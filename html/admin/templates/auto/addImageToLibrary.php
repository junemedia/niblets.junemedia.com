<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

/**
 * take an image url, upload the image to the media library and
 * return the assets new url
 */
echo generateImgUrl($_GET['imageurl']);
