<?php

include_once("../../../includes/paths.php");


mysql_select_db( $templatesDB );

require_once("template_class.php");

if ($iId == '' || !ctype_digit($iId)) {
  echo 'id missing';
  exit;
}

$query = "SELECT * FROM automated WHERE id = '$iId'";
$rSelectResult = mysql_query($query);
echo mysql_error();
while ($oRow = mysql_fetch_object($rSelectResult)) {
  $template = $oRow->template;
}
$preview  = new Template("templates/$template");

$query = "SELECT * FROM automated_map WHERE automated_id = '$iId'";
$rSelectResult = mysql_query($query);
echo mysql_error();
while ($oRow = mysql_fetch_object($rSelectResult)) {
  // strip square brackets from tag_key
  $tag_key = str_replace(array('[', ']'), '', $oRow->tag_key);
  if ($oRow->tag_value != '') {
    $preview->set($tag_key, $oRow->tag_value);
  }
}

$html_code = $preview->output();







echo $preview->output();
