<?php

include_once("../../../includes/paths.php");
mysql_select_db( $templatesDB );

session_start();
$sList = '';

$query_filter = "";
if (isset($submit) && $submit == 'Search...') {
  if ($template != '') {
    $query_filter .= " AND template = \"$template\"";
  }
}

// get 50 most recent and build html table as a string
$sql = "SELECT * FROM automated WHERE 1=1 $query_filter ORDER BY id DESC LIMIT 50";
$rSelectResult = dbQuery($sql);

if (dbNumRows($rSelectResult) == 0) {
  $sMessage = "No Records Exist...";
}


// templates select form field
$template_options = "<option></option>";

if ($scanned = scandir('templates')) {
  foreach ($scanned as $entry) {
    // only show php files
    if (substr($entry, -4) === '.php') {
      if (isset($template) && $template == strtolower($entry)) {
        $selected = 'selected';
      } else {
        $selected = '';
      }
      $template_options .= "<option value='$entry' $selected>$entry</option>";
    }
  }
}


include_once("partials/newsletter_listing.php");
