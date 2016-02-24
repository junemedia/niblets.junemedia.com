<?php

include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");

// duplicates generateImgUrl function in create.php
$url = $_GET['image'];
if (!strstr($url,'media.campaigner.com')) {
  $outputfile = 'upload_imgs/'.basename($url);
  $output = shell_exec("wget '".$url."' -O '".$outputfile."' 2>&1");
  $send_result = UploadMediaFileCampaigner(trim($outputfile));

  // check ReturnMessage for success status
  if (strstr(strtolower(trim(getXmlValueByTag($send_result,'ReturnMessage'))),'success')) {
    @unlink($outputfile);
    echo trim(getXmlValueByTag($send_result,'FileURL'));
  } else {
    mail('johns@junemedia.com','MOVE upload image error',$send_result);
    echo $send_result;
  }
}
exit;
