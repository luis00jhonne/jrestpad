<?php if(isset($doctype)) echo "<!DOCTYPE html>" ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="public/assets/css/main.css" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>JRESTPad <?php if(isset($page_title)) echo "| " . $page_title  ?></title>
</head>
<body>
	 <?php if(isset($view_filename)) require $view_filename?>
</body>
</html>