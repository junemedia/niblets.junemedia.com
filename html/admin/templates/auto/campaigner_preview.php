<?php

include_once("../../../includes/paths.php");
include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");

mysql_select_db( $templatesDB );

require_once("template_class.php");

$html_code = buildPreview($iId);
echo $html_code;
