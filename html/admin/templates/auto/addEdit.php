<?php

/*
 * this page doesn't make any api calls, just database
 */

include_once("../../../includes/paths.php");

// default values
$refresh = '';
$error = '';

// got here via submit button
if (isset($submit) && $submit == 'Add/Update') {
  // process only if there are no errors, though I can't see where
  // an error would be getting set
  if ($error == '') {
    if ($iId == '') {
      // No id means new newsletter

      // make inputs db friendly
      $subject = addslashes($subject);
      $mailing_date = addslashes($mailing_date);
      $template = addslashes($template);
      $enable = addslashes($enable);
      $meta_keywords = addslashes($meta_keywords);
      $meta_desc = addslashes($meta_desc);

      $insert = "INSERT IGNORE INTO automated (
                    subject,
                    mailing_date,
                    enable,
                    meta_keywords,
                    meta_desc,
                    template,
                    from_name,
                    from_email_id,
                    reply_email_id,
                    campaign_name)
                VALUES (
                    \"$subject\",
                    \"$mailing_date\",
                    \"$enable\",
                    \"$meta_keywords\",
                    \"$meta_desc\",
                    \"$template\",
                    \"$from_name\",
                    \"$from_email_id\",
                    \"$reply_email_id\",
                    \"$campaign_name\")";
      $result = mysql_query($insert);
      echo mysql_error();

      $iId = mysql_insert_id();
      $error = "Insert Success";
    }
    else {
      // update existing newsletter
      $update = "UPDATE automated SET
                    subject=\"$subject\",
                    mailing_date=\"$mailing_date\",
                    enable=\"$enable\",
                    meta_keywords=\"$meta_keywords\",
                    meta_desc=\"$meta_desc\",
                    template=\"$template\",
                    from_name=\"$from_name\",
                    from_email_id=\"$from_email_id\",
                    reply_email_id=\"$reply_email_id\",
                    campaign_name=\"$campaign_name\"
                WHERE id = \"$iId\"";
      $result = mysql_query($update);
      echo mysql_error();
      $error = "Update Success";
    }
  }

  // read template and find all of the variable tags
  $html = file_get_contents("templates/$template");

  // looking for variables of form {{/my_variable/}}
  $var_pattern = "/{{\/([a-zA-Z0-9_]+?)\/}}/";
  preg_match_all($var_pattern, $html, $fields);
  $tags = array_unique ( $fields[1] );

  $curr_year = date('Y');

  // insert [mostly] blank key/value pairs into `automated_map`
  foreach ($tags as $tag) {
    switch ($tag) {
      case "ISSUE_DATE":
        $insert = "REPLACE INTO automated_map (
                      automated_id,
                      tag_key,
                      tag_value)
                  VALUES (
                      \"$iId\",
                      \"$tag\",
                      \"$mailing_date\")";
        break;
      case "CURRENT_YEAR":
        $insert = "REPLACE INTO automated_map (
                      automated_id,
                      tag_key,
                      tag_value)
                  VALUES (
                      \"$iId\",
                      \"$tag\",
                      \"$curr_year\")";
        break;
      default:
        $insert = "INSERT IGNORE INTO automated_map (
                      automated_id,
                      tag_key)
                  VALUES (
                      \"$iId\",
                      \"$tag\")";
    }
    $result = mysql_query($insert);
    echo mysql_error();
  }
  // will refresh the parent window, i.e. Newsletters Automation
  $refresh = "<script>window.opener.location = '/admin/templates/auto/index.php';</script>";
}


if (isset($iId) && $iId != '') {
  // PULL DATA FROM DB AND FILL BELOW FORM
  $get_data_result = mysql_query("SELECT * FROM automated WHERE id = \"$iId\"");
  while ($data_row = mysql_fetch_object($get_data_result)) {
    $subject = $data_row->subject;
    $mailing_date = $data_row->mailing_date;
    $enable = $data_row->enable;
    $meta_keywords = $data_row->meta_keywords;
    $meta_desc = $data_row->meta_desc;
    $template = strtolower($data_row->template);
    $from_name = $data_row->from_name;
    $from_email_id = $data_row->from_email_id;
    $reply_email_id = $data_row->reply_email_id;
    $campaign_name = $data_row->campaign_name;
  }
  if (mysql_num_rows($get_data_result) == 0) {
    $error = "No Record Found";
    $iId = '';  // clear iId since we can't find this record
  }
}
else {
  $mailing_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
}


$template_options = "";
if ($scanned = scandir('templates')) {
  foreach ($scanned as $entry) {
    // only show php files
    if (substr($entry, -4) === '.php') {
      if (isset($template) && $template == strtolower($entry)) {
        $selected = 'selected';
      }
      else {
        $selected = '';
      }
      $template_options .= "<option value='$entry' $selected>$entry</option>";
    }
  }
}


include_once("partials/addEdit.html");
