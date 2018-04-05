<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

// duplicates generateImgUrl function in create.php
$imageurl = $_GET['imageurl'];

if (!strstr($imageurl,'maropost.s3.amazonaws.com') && !strstr($imageurl, 'cdn.maropost.com')) {

  // expecting to get back an object here
  $response = addImageToLibrary($imageurl);

  // if image_url is in response then it was successful
  if (true || isset($response->{'image_url'})) {
    echo $response->{'image_url'};
  }
  else {
    mail('johns@junemedia.com','MOVE upload image error', json_encode($response));
    echo json_encode($response);
  }
}
exit;
