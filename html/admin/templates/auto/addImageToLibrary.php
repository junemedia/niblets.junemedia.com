<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

// duplicates generateImgUrl function in edit.php
$imageurl = $_GET['imageurl'];

// don't bother if image is already in the media library
if (!strstr($imageurl, MEDIALIBRARY)) {

  // expecting to get back an object here
  $response = addImageToLibrary($imageurl);

  // if image_url is in response then it was successful
  if (isset($response->data->url)) {
    echo $response->data->url;    // a string
  }
  else {
    mail('johns@junemedia.com','MOVE upload image error', json_encode($response));
    echo json_encode($response);
  }
}
exit;
