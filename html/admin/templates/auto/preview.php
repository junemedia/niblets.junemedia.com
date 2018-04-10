<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

mysql_select_db( $templatesDB );

require_once("template_class.php");

$html_code = buildPreview($iId);
echo $html_code;
