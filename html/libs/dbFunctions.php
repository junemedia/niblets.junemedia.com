<?php

// customized db functions

function dbConnect($dbHost, $dbUser, $dbPass) {
  $rLink = @mysql_connect ($dbHost, $dbUser ,$dbPass);
  if ($rLink)
    return ($rLink);
  else
    return 0 ;
}

function dbSelect($dbName) {
  return (mysql_select_db($dbName) );
}

function dbInsertId() {
  return (mysql_insert_id() );
}

function dbNumRows($rResult) {
  if ($rResult) {
    return (mysql_num_rows($rResult));
  }

}

function dbAffectedRows() {
  return (mysql_affected_rows());
}

function dbDataSeek ($rResult, $iOffset) {
  if ($rResult) {
    return (mysql_data_seek ($rResult, $iOffset) );
  }
}

function dbFetchObject($rResult) {
  if ($rResult) {
    return (mysql_fetch_object($rResult));
  }
}

function dbFetchArray($rResult) {
  if ($rResult) {
    return (mysql_fetch_array($rResult));
  }
}

function dbFetchRow($rResult) {
  if ($rResult) {
    return (mysql_fetch_row($rResult));
  }
}

function dbErrno() {
  return (mysql_errno());
}

function dbError() {
  return (mysql_error( ));
}

function dbFreeResult($rResult) {
  if ($rResult) {
    return (mysql_free_result($rResult));
  }
}

function dbNumFields($rResult) {
  if ($rResult) {
    return (mysql_num_fields($rResult));
  }
}

function dbFetchField($rResult) {
  if ($rResult) {
    return (mysql_fetch_field($rResult));
  }
}

function dbFieldName($rResult, $iFieldNum) {
  if ($rResult) {
    return (mysql_field_name($rResult, $iFieldNum));
  }
}


function dbQuery($sQuery) {
  $rResult = mysql_query($sQuery);

  if (!$rResult) {
    return 0;
  }
  else {
    return($rResult);
  }
}
